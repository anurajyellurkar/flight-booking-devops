pipeline {
    agent any

    stages {

        stage('Checkout Code') {
            steps {
                git 'https://github.com/anurajyellurkar/flight-booking-devops.git'
            }
        }

        stage('PHP Syntax Check') {
            steps {
                sh 'php -l src/index.php'
            }
        }

        stage('Build Docker Image') {
            steps {
                sh 'docker build -t flight-app:latest .'
            }
        }

        stage('Trivy Scan') {
            steps {
                sh 'trivy image flight-app:latest'
            }
        }

        stage('Deploy Application') {
            steps {
                sh 'docker-compose down'
                sh 'docker-compose up -d'
            }
        }
    }
}
