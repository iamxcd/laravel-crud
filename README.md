

## 安装
    composer require iamxcd/laravel-crud
    
## 筛选器 语法

- [x]  "cs": contain string (包含字符串)
- [ ]  "sw": start with (开始包含)
- [ ]  "ew": end with (结束包含)
- [x]  "eq": equal (字符串或者数字完全匹配  可以省略)
- [ ]  "lt": lower than (数字小于)
- [ ]  "le": lower or equal (小于等于)
- [ ]  "ge": greater or equal (大于等于)
- [ ]  "gt": greater than (大于)
- [ ]  "bt": between (介于两者之间)
- [ ]  "in": in (用半角逗号分开,筛选的值位于这些值之间)

```
// 筛选器 使用示例

/user?age=ge,18&sex=女  // 筛选出大于等于18的女性用户.
/user?age=bt,18,28  // 筛选出年龄在18到28之间的用户
/user?name=sw,张  // 筛选出姓名首字是"张"的用户
/user?name=cs,张  // 筛选出姓名中含有"张"的用户
/user?job=in,程序员,教师,销售  // 筛选出职业是程序员,教师,销售的用户
```

## 排序说明
```
/user?age=ge,18&_sort=age,desc  // 筛选出大于等于18的用户,按照年龄从大到小排列 降序
/user?age=ge,18&_sort=age  // 筛选出大于等于18的用户,按照年龄从小到大排列 升序不用加 默认升序
```

## 注意
    所有需要排序的字段和筛选需要后端添加白名单.