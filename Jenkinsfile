pipeline {
    agent any

    environment {
        DOCKER_IMAGE_NAME = "your-dockerhub-username/your-app-name"
        DOCKER_IMAGE_TAG  = "latest"
        DOCKER_REGISTRY_CREDENTIALS_ID = "dockerhub-credentials" // Change this to your Docker Hub credentials ID in Jenkins
    }

    stages {
        stage('Checkout') {
            steps {
                // Get some code from a GitHub repository
                git 'https://github.com/your-username/your-repo-name.git' // Change this to your repository
            }
        }

        stage('Build') {
            steps {
                script {
                    echo "Building the Docker image..."
                    sh "docker build -t ${DOCKER_IMAGE_NAME}:${DOCKER_IMAGE_TAG} ."
                }
            }
        }

        stage('Test') {
            steps {
                script {
                    echo "Running tests..."
                    sh "docker run --rm -v ${pwd()}:/var/www/html ${DOCKER_IMAGE_NAME}:${DOCKER_IMAGE_TAG} vendor/bin/phpunit"
                }
            }
        }

        stage('Push') {
            steps {
                script {
                    echo "Pushing the Docker image..."
                    withCredentials([string(credentialsId: DOCKER_REGISTRY_CREDENTIALS_ID, variable: 'DOCKER_HUB_PASSWORD')]) {
                        sh "echo ${DOCKER_HUB_PASSWORD} | docker login -u your-dockerhub-username --password-stdin"
                        sh "docker push ${DOCKER_IMAGE_NAME}:${DOCKER_IMAGE_TAG}"
                    }
                }
            }
        }

        stage('Deploy') {
            steps {
                script {
                    echo "Deploying the application..."
                    // Add your deployment steps here
                    // For example, you might use kubectl, docker-compose, or ssh to deploy your application
                }
            }
        }
    }

    post {
        always {
            echo 'Pipeline finished.'
            script {
                // Clean up Docker images
                sh "docker rmi ${DOCKER_IMAGE_NAME}:${DOCKER_IMAGE_TAG}"
            }
        }
    }
}
