pipeline {
    agent any
    environment {
        SCANNER_HOME = tool 'SonarScanner'
    }
    stages {
        stage('Checkout') {
            steps {
                git branch: 'main',
                    url: 'https://github.com/rajkumar-beep/webiste-test.git',
                    credentialsId: 'github-token'
            }
        }
        stage('Verify Files') {
            steps {
                sh 'ls -la'
            }
        }
        stage('SonarQube Scan') {
            steps {
                withSonarQubeEnv('SonarQubeServer') {
                    sh '''
                    ${SCANNER_HOME}/bin/sonar-scanner \
                      -Dsonar.projectKey=jenkins-test \
                      -Dsonar.sources=.
                    '''
                }
            }
        }
        stage('Package Artifact') {
            steps {
                sh '''
                zip -r webiste-test.zip . -x ".git/*" -x ".gitignore"
                sha256sum webiste-test.zip > webiste-test.zip.sha256
                cat webiste-test.zip.sha256
                ls -la webiste-test.zip
                '''
            }
        }
        stage('Upload to S3') {
            steps {
                sh '''
                aws s3 cp webiste-test.zip s3://webiste-test-artifacts-prod/webiste-test.zip
                aws s3 cp webiste-test.zip.sha256 s3://webiste-test-artifacts-prod/webiste-test.zip.sha256
                '''
            }
        }
    }
}
