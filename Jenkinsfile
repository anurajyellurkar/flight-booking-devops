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
                withCredentials([usernamePassword(credentialsId: 'dockerhub', usernameVariable: 'USER', passwordVariable: 'PASS')]) {
                    sh 'echo $PASS | docker login -u $USER --password-stdin'
                    sh 'docker push $IMAGE_NAME'
                }
            }
        }
    }
}
