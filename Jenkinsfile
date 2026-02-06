import groovy.json.JsonOutput

def sendWebhook(status, progress, stageName) {
    def payload = """
{"jobName":"${env.JOB_NAME}","buildNumber":"${env.BUILD_NUMBER}","status":"${status}","progress":${progress},"stage":"${stageName}"}
"""
    if (env.WEBUI_API?.trim()) {
        writeFile file: 'webui_payload.json', text: payload
        sh(returnStatus: true, script: "curl -s -X POST '${env.WEBUI_API}/api/webhooks/jenkins' -H 'Content-Type: application/json' --data @webui_payload.json || true")
    }
}

def registerPending(file) {
    def http = sh(script: "curl -sS -o /dev/null -w '%{http_code}' -X POST '${env.WEBUI_API}/api/jenkins/pending' -H 'Content-Type: application/json' --data @${file}", returnStdout: true).trim()
    if (!(http ==~ /2\d\d/)) {
        error "Failed to register approval in WebUI (HTTP ${http}). WEBUI_API=${env.WEBUI_API}"
    }
}

def triggerSync() {
    def auth = env.SYNC_JOB_TOKEN?.trim() ? "-H 'Authorization: Bearer ${env.SYNC_JOB_TOKEN}'" : ''
    sh(returnStatus: true, script: "curl -sS -X POST '${env.WEBUI_API}/api/sync' ${auth} || true")
}

pipeline {
    agent any

    environment {
        APP_NAME       = "room-booking"
        DOCKER_IMAGE   = "devopsnaratel/room-booking"
        DOCKER_CRED_ID = "docker-hub"

        // Optional: set a Jenkins credential that can push tags back to your git repo.
        // If unset/invalid, tagging still works locally; pushing tags becomes best-effort.
        GIT_CRED_ID    = "git-token"

        // URL WebUI Base
        WEBUI_API      = "https://nonfortifiable-mandie-uncontradictablely.ngrok-free.dev"
        // Optional token for /api/sync
        SYNC_JOB_TOKEN = ""
    }

    stages {
        stage('Checkout & Get Version') {
            steps {
                script {
                    sendWebhook('STARTED', 2, 'Checkout')
                    checkout scm
                    sh "git fetch --tags --force"

                    def latestTag = sh(script: "git tag --sort=-creatordate | head -n 1", returnStdout: true).trim()
                    if (!latestTag) {
                        def newTag = "v0.0.0-build-${env.BUILD_NUMBER}"
                        echo "No git tags found. Creating tag: ${newTag}"
                        sh "git tag -a ${newTag} -m 'Auto tag ${newTag}'"

                        // Best-effort push. If credentials are not available, the pipeline continues.
                        try {
                            withCredentials([usernamePassword(credentialsId: env.GIT_CRED_ID, usernameVariable: 'GIT_USER', passwordVariable: 'GIT_TOKEN')]) {
                                // Prefer pushing to origin; if origin requires auth, configure it in Jenkins.
                                sh(returnStatus: true, script: "git push origin ${newTag} || true")
                            }
                        } catch (e) {
                            echo "Skipping git tag push (no credentials or push failed): ${e}"
                        }

                        sh "git fetch --tags --force"
                        latestTag = newTag
                    }

                    if (!latestTag?.trim()) {
                        error("APP_VERSION is empty after tag resolution. Aborting.")
                    }
                    env.APP_VERSION = latestTag.trim()
                    echo "Building Version: ${env.APP_VERSION}"
                    sendWebhook('IN_PROGRESS', 8, 'Checkout')
                }
            }
        }

        stage('Build & Push Docker') {
            steps {
                script {
                    sendWebhook('IN_PROGRESS', 20, 'Build')
                    docker.withRegistry('', env.DOCKER_CRED_ID) {
                        def img = docker.build("${env.DOCKER_IMAGE}:${env.APP_VERSION}")
                        img.push()
                        img.push("latest")
                    }
                    sendWebhook('IN_PROGRESS', 40, 'Build')
                }
            }
        }

        stage('Configuration & Approval') {
            steps {
                script {
                    sendWebhook('IN_PROGRESS', 55, 'Approval')
                    def payloadObj = [
                        appName    : env.APP_NAME,
                        buildNumber: env.BUILD_NUMBER.toString(),
                        version    : env.APP_VERSION,
                        jenkinsUrl : (env.BUILD_URL ?: '').toString(),
                        inputId    : 'ApproveDeploy',
                        source     : 'jenkins'
                    ]
                    writeFile file: 'pending_payload.json', text: JsonOutput.toJson(payloadObj)
                    registerPending('pending_payload.json')

                    input message: "Waiting for configuration & approval from Dashboard...", id: 'ApproveDeploy'
                }
            }
        }

        stage('Deploy Testing (Ephemeral)') {
            steps {
                script {
                    sendWebhook('IN_PROGRESS', 65, 'Deploy Testing')
                    def deployPayload = JsonOutput.toJson([
                        appName : env.APP_NAME,
                        imageTag: env.APP_VERSION,
                        source  : 'jenkins'
                    ])

                    sh(returnStatus: true, script: "curl -sS -X POST ${env.WEBUI_API}/api/jenkins/deploy-test -H 'Content-Type: application/json' -d '${deployPayload}' || true")
                    triggerSync()
                    sleep 60
                }
            }
        }

        stage('Integration Tests') {
            steps {
                script {
                    sendWebhook('IN_PROGRESS', 80, 'Tests')
                    echo "Running Tests..."
                }
            }
        }

        stage('Final Production Approval') {
            steps {
                script {
                    sendWebhook('IN_PROGRESS', 90, 'Prod Approval')
                    def payloadFinal = [
                        appName    : env.APP_NAME,
                        buildNumber: env.BUILD_NUMBER.toString(),
                        version    : env.APP_VERSION,
                        jenkinsUrl : (env.BUILD_URL ?: '').toString(),
                        inputId    : 'ConfirmProd',
                        isFinal    : true,
                        source     : 'jenkins'
                    ]
                    writeFile file: 'pending_payload_final.json', text: JsonOutput.toJson(payloadFinal)
                    registerPending('pending_payload_final.json')

                    input message: "Waiting for Final Production Confirmation...", id: 'ConfirmProd'
                }
            }
        }

        stage('Deploy to Production') {
            steps {
                script {
                    sendWebhook('IN_PROGRESS', 95, 'Deploy Production')
                    def updatePayload = JsonOutput.toJson([
                        appName : env.APP_NAME,
                        env     : 'prod',
                        imageTag: env.APP_VERSION,
                        source  : 'jenkins'
                    ])
                    sh(returnStatus: true, script: "curl -sS -X POST ${env.WEBUI_API}/api/manifest/update-image -H 'Content-Type: application/json' -d '${updatePayload}' || true")
                    triggerSync()
                }
            }
        }
    }

    post {
        success { script { sendWebhook('SUCCESS', 100, 'Completed') } }
        failure { script { sendWebhook('FAILED', 100, 'Failed') } }
        always {
            script {
                def destroyPayload = JsonOutput.toJson([appName: env.APP_NAME])
                sh(returnStatus: true, script: "curl -sS -X POST ${env.WEBUI_API}/api/jenkins/destroy-test -H 'Content-Type: application/json' -d '${destroyPayload}' || true")
                triggerSync()
            }
            cleanWs()
        }
    }
}
