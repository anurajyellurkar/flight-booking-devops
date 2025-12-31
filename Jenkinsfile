pipeline {
    agent any

    environment {
        IMAGE_NAME = "anuraj2913/flight-booking:latest"
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
                sh '''
                trivy fs --cache-dir /tmp/trivy .
                rm -rf /tmp/trivy/*
                '''
            }
        }

        stage('Build Docker Image') {
            steps {
                sh 'docker build -t $IMAGE_NAME .'
            }
        }

        stage('Trivy Scan - Docker Image') {
            steps {
                sh '''
                trivy image --cache-dir /tmp/trivy $IMAGE_NAME
                rm -rf /tmp/trivy/*
                '''
            }
        }

        stage('Login & Push Image to Docker Hub') {
            steps {
                withCredentials([usernamePassword(
                    credentialsId: 'dockerhub',
                    usernameVariable: 'USER',
                    passwordVariable: 'PASS'
                )]) {
                    sh '''
                    echo $PASS | docker login -u $USER --password-stdin
                    docker push $IMAGE_NAME
                    '''
                }
            }
        }

        stage('Deploy to EC2') {
            steps {
                sshagent (credentials: ['ec2-ssh']) {
                    sh '''
                    ssh -o StrictHostKeyChecking=no ubuntu@13.50.105.44 '
                        docker stop app || true &&
                        docker rm app || true &&

                        docker pull anuraj2913/flight-booking:latest &&

                        docker run -d --name app -p 80:80 \
                        -e DB_HOST=13.50.105.44 \
                        -e DB_USER=root \
                        -e DB_PASS=root \
                        -e DB_NAME=flight_booking \
                        anuraj2913/flight-booking:latest
                    '
                    '''
                }
            }
        }
    }
}
