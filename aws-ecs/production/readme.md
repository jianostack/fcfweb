### ecs-cli compose service create

ecs-cli compose --project-name fcfweb-production --ecs-params ecs-params.yml --file ecs-service.yml service create --create-log-groups --tags project=fcfweb --cluster fcfweb-production-ECSCluster-nHrOeb4A5eR6 --launch-type EC2 --target-groups "targetGroupArn=arn:aws:elasticloadbalancing:ap-southeast-1:298842265645:targetgroup/fcfweb-production/7546772edb14e3df,containerName=fcfweb,containerPort=80" --health-check-grace-period 30 --aws-profile fisherman

### ecs-cli compose service up

ecs-cli compose --project-name fcfweb-production --ecs-params ecs-params.yml --file ecs-service.yml service up --cluster fcfweb-production-ECSCluster-nHrOeb4A5eR6 --aws-profile fisherman


