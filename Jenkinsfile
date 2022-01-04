node {
   // Mark the code checkout 'stage'....
   stage 'Checkout'

   // Checkout code from repository
   checkout scm

   stage ('Deploy') {
       build job: 'php-admin-portal', parameters: [[$class: 'StringParameterValue', name: 'payload', value:"${BRANCH_NAME}" ]]
   }
}