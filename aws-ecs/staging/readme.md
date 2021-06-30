### ecs-cli compose service create

ecs-cli compose \
--project-name fcfweb-staging \
--ecs-params ecs-params.yml \
--file ecs-service.yml \
service create \
--create-log-groups \
--tags project=fcfweb \
--cluster fcfweb-production-ECSCluster-nHrOeb4A5eR6 \
--launch-type EC2 \
--target-groups "targetGroupArn=arn:aws:elasticloadbalancing:ap-southeast-1:298842265645:targetgroup/fcfweb-staging/e2946a46e0da2fc9,containerName=fcfweb,containerPort=80" \
--health-check-grace-period 30 \
--aws-profile fcf

### ecs-cli compose service up

ecs-cli compose \
--project-name fcfweb-staging \
--ecs-params ecs-params.yml \
--file ecs-service.yml \
service up \
--cluster fcfweb-production-ECSCluster-nHrOeb4A5eR6 \
--aws-profile fcf


