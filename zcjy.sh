#!/bin/sh

#首先配置好.env配置 复制.zcjy.config到.env
cp .zcjy.config .env 
echo "网站env配置文件配置成功"

#首先创建basic上传目录
cd public/ && mkdir uploads/ && mkdir thumbs/ && chmod -R 777 uploads/ thumbs/ && cd ../ && 
echo "网站上传目录创建成功"

#然后初始化环境composer 并且生成数据表结构和填充初始化数据
composer install && echo "composer扩展环境已搭建成功" && php artisan migrate && echo "网站数据表结构已创建成功" && php artisan db:seed && echo "网站填充数据已初填充成功" && chmod -R 777 storage && echo "网站已初始化成功"