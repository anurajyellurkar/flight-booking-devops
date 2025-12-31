pipeline {
    agent any

    environment {
        IMAGE_NAME = "anuraj2913/flight-booking"
    }

    stages {

        stage('Checkout Code') {
            steps {
                git branch: 'main',
                    url: 'https://github.com/anurajyellurkar/flight-booking-devops.git'
            }
        }

        stage('Trivy Scan - Filesystem') {
            steps {
                sh 'trivy fs .'
            }
        }

        stage('Build Docker Image') {
            steps {
                sh 'docker build -t $IMAGE_NAME .'
            }
        }

        stage('Trivy Scan - Docker Image') {
            steps {
                sh 'trivy image $IMAGE_NAME'
            }
        }

        stage('Login & Push Image to Docker Hub') {
            steps {
                withCredentials([usernamePassword(
                    credentialsId: 'dockerhub',
                    usernameVariable: 'USER',
                    passwordVariable: 'PASS'
                )]) {
                    sh 'echo $PASS | docker login -u $USER --password-stdin'
                    sh 'docker push $IMAGE_NAME'
                }
            }
        }

        stage('Deploy to EC2') {
            steps {
                sshagent (credentials: ['ec2-ssh']) {
                    sh '''
                    ssh -o StrictHostKeyChecking=no ubuntu@13.50.105.44 "
                        docker pull anuraj2913/flight-booking &&
                        docker stop app || true &&
                        docker rm app || true &&
                        docker run -d --name app -p 80:80 anuraj2913/flight-booking
                    "
                    '''
                }
            }
        }
    }
}
