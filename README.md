

## 安装
    composer require iamxcd/laravel-crud
    
## 筛选器 语法

- [x]  "like": 包含
- [x]  "=": 等于
- [x]  "<": 小于
- [x]  "<=": 小于等于
- [x]  ">=": 大于等于
- [x]  ">": 大于
- [x]  "boolean": 布尔值 用于区分 布尔值和字符串 true|false laravel 在数据库中存的值是0|1需要转化一下
- [ ]  "bt": between (介于两者之间)
- [ ]  "in": in (用半角逗号分开,筛选的值位于这些值之间)

## 注意
    所有需要排序的字段和筛选需要后端添加白名单.

## 中间件
    ForceJson.php

## 表单验证失败
    HasOverrideFailedValidation.php