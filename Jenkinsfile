pipeline {
    agent any

    environment {
        REGISTRY        = "docker.io"
        IMAGE_NAME      = "rhan33/laravel-room-booking"
        IMAGE_TAG       = "${env.GIT_COMMIT}"
        DOCKER_CREDS    = "dckr_pat_UNBKExsXZKCqDGWFItJBZFYwh9Y"
    }

    options {
        timestamps()
        disableConcurrentBuilds()
    }

    stages {

        stage('Checkout') {
            steps {
                checkout scm
            }
        }

        stage('Build Image') {
            steps {
                script {
                    sh """
                      docker build \
                        -t ${IMAGE_NAME}:${IMAGE_TAG} \
                        .
                    """
                }
            }
        }

        stage('Test') {
            steps {
                script {
                    sh """
                      docker run --rm \
                        ${IMAGE_NAME}:${IMAGE_TAG} \
                        php artisan test
                    """
                }
            }
        }

        stage('Push Image') {
            steps {
                script {
                    docker.withRegistry("https://${REGISTRY}", DOCKER_CREDS) {
                        sh "docker push ${IMAGE_NAME}:${IMAGE_TAG}"
                        sh "docker tag ${IMAGE_NAME}:${IMAGE_TAG} ${IMAGE_NAME}:latest"
                        sh "docker push ${IMAGE_NAME}:latest"
                    }
                }
            }
        }
    }

    post {
        always {
            echo "Pipeline finished"
            sh "docker image prune -f || true"
        }
        success {
            echo "Build & Deploy successful 🚀"
        }
        failure {
            echo "Pipeline failed ❌"
        }
    }
}
