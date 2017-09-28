DATE=$(date +"%d/%m/%Y_%H:%M:%S")

cd /var/www/magento2/
echo " - 1 - Clean du cache de la solution magento"
php bin/magento cache:clean

echo " - 2 - Remove di and generation"
rm -rf var/di/* var/generation/*

echo " - 3 - Upgrade de la solution magento"
php bin/magento setup:upgrade

echo " - 4 - petit di:compile"
php ./bin/magento setup:di:compile


clear

