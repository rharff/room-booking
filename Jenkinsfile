pipeline {
  agent any

  environment {
    IMAGE_NAME = "rhan33/room-booking"
    IMAGE_TAG  = "staging-${BUILD_NUMBER}"
    FULL_IMAGE = "${IMAGE_NAME}:${IMAGE_TAG}"
  }

  stages {
    stage('Checkout') {
      steps {
        checkout scm
      }
    }

    stage('Build and Push to Docker Hub') {
      steps {
        // Ensure you have created credentials in Jenkins with ID 'dockerhub'
        withCredentials([
          usernamePassword(
            credentialsId: 'dockerhub',
            usernameVariable: 'DOCKER_USER',
            passwordVariable: 'DOCKER_PASS'
          )
        ]) {
          sh '''
            # Login to Docker Hub
            echo "${DOCKER_PASS}" | docker login -u "${DOCKER_USER}" --password-stdin

            # Build the Docker image
            docker build -t ${FULL_IMAGE} .
            
            # Also tag it as 'latest' for convenience
            docker tag ${FULL_IMAGE} ${IMAGE_NAME}:${IMAGE_TAG}

            # Push both tags
            docker push ${FULL_IMAGE}
            docker push ${IMAGE_NAME}:${IMAGE_TAG}

            # Clean up local images to save disk space on the Jenkins agent
            docker rmi ${FULL_IMAGE} ${IMAGE_NAME}:${IMAGE_TAG}
          '''
        }
      }
    }

    stage('Update Kubernetes Manifest (GitOps)') {
      steps {
        withCredentials([
          usernamePassword(
            credentialsId: 'github',
            usernameVariable: 'GIT_USER',
            passwordVariable: 'GIT_TOKEN'
          )
        ]) {
          sh '''
            # Update the image tag in the deployment manifest
            sed -i "s|image: .*|image: ${FULL_IMAGE}|" \
              k8s/staging/deployment.yaml

            git config user.name "rharff"
            git config user.email "rharff@gmail.com"

            git add k8s/staging/deployment.yaml
            git commit -m "ci: deploy staging ${IMAGE_TAG}" || echo "No changes to commit"

            # Set the remote URL with credentials for pushing
            git remote set-url origin \
              https://${GIT_USER}:${GIT_TOKEN}@github.com/rharff/room-booking.git

            git push origin HEAD:main
          '''
        }
      }
    }
  }

  post {
    success {
      echo "✅ Image pushed and Manifest updated → ArgoCD will deploy ${FULL_IMAGE}"
    }
    failure {
      echo "❌ Pipeline failed"
    }
  }
}