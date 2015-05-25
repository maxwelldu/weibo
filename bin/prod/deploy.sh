composer install
./init --env=Production --overwrite=y
./yii migrate --interactive=0
# 服务器环境的更新