# AliCloud_Demo_AIRec

# Alibaba Cloud AIRec
[about](https://help.aliyun.com/document_detail/98231.html)

AIRec = Artificial Intelligence Recommendation

Instance = vertical + scenario + dataversion + 

## Vertical: commerce, content, news, video, social network
1. commerce: 主要指电商相关行业，需要向用户推荐的物品带有 __商品属性__（物流信息，售卖信息等），可以引导直接交易，对点击购买率有一定要求。常见的案例有淘宝，天猫等。
2. content: 主要指内容分享平台行业，推荐的内容带有 __分享属性__（点赞，转发等），可以是较短文本、文章、图片等，或者上述内容类型的混合。常见的案例如堆糖、aloha等。
3. news: 主要指新闻相关行业，需要向用户推荐的物品带有 __新闻属性__（作者，发布地域，时间等），是传播信息的一种文体，对__实效性__有一定的敏感性。常见的案例有惠头条，趣闻等。

## Scenario: todo:

客户配置好智能推荐实例的行业模板后，就不能修改了

首页推荐猜你喜欢、相关推荐、热门推荐和焦点图推荐

Infrastructure: MaxCompute + OSS + Dataworks

## data flow:
![alt](/images/airec_workflow.png)
![alt](/images/airec_dataflow.png)

## data dictionary
### content 
1. [item](https://help.aliyun.com/document_detail/99248.html)
```
1 item_id: 
2 item_type: [image | article | video | shortvideo | item | recipe]
3 status: [0 | 1]
```
2. [user](https://help.aliyun.com/document_detail/99248.html)
```
1. user_id: 
```
3. [behavior](https://help.aliyun.com/document_detail/99248.html)
```
1. item_id: needs to be with item_id
2 item_type:
3 bhv_type: [explose |  click | like | unlike | comment |  collect |  stay |  share |  download |  tip |  subscribe]
4 bhv_value: 
5 user_id:
5 trace_id: [Alibaba | selfhold]
```
### ecommerce
1. [item](https://help.aliyun.com/document_detail/99249.html)
```
1 item_id: 
2 item_type: [image | article | video | shortvideo | item | recipe]
3 status: [0 | 1]
```
2. [user](https://help.aliyun.com/document_detail/99249.html)
```
1. user_id: 
```
3. [behavior](https://help.aliyun.com/document_detail/99249.html)
```
1. item_id: needs to be with item_id
2 item_type:
3 bhv_type: [explose |  click | like | comment |  collect |  stay ]
4 bhv_value: 
5 user_id:
5 trace_id: [Alibaba | selfhold]
```

### news
1. [item](https://help.aliyun.com/document_detail/99250.html)
```
1 item_id: 
2 item_type: [image | article | video | shortvideo | item | recipe]
3 status: [0 | 1]
```
2. [user](https://help.aliyun.com/document_detail/99250.html)
```
1. user_id: 
```
3. [behavior](https://help.aliyun.com/document_detail/99250.html)
```
1. item_id: needs to be with item_id
2 item_type:
3 bhv_type: [explose |  click | like | unlike | comment |  collect |  stay |  share |  download | tip |  subscribe]
4 bhv_value: 
5 user_id:
5 trace_id: [Alibaba | selfhold]
```

# demo

## first time data preparation in dataworks
### create a workspace in simple mode
![image](/images/dw_create_workspace_en_1.jpg)
![image](/images/dw_create_workspace_en_2.jpg)

智能推荐服务只使用了MaxCompute的存储功能，用户只需提供工作空间的名称作为project name，以及三张表名即可。
MaxCompute中的全量数据，智能推荐系统只会在初始化时读取一次，后续增量等相关信息不会回写该项目，后续用户对里面的数据进行增删改查，都不会影响智能推荐服务。

### upload data from local into dataworks
#### enable [odpscmd](http://repo.aliyun.com/odpscmd/) in your local environment
```
mkdir odpscmd & cd odpscmd
wget http://repo.aliyun.com/download/odpscmd/0.30.2/odpscmd_public.zip
tar zxf odpscmd_public.zip
```


```
CREATE TABLE IF NOT EXISTS behavior_news (trace_id STRING COMMENT "请求追踪/埋点ID",trace_info STRING COMMENT "请求埋点信息",platform STRING COMMENT "客户端平台",device_model STRING COMMENT "设备型号",imei STRING COMMENT "设备ID",app_version STRING COMMENT "app的版本号",net_type STRING COMMENT "网络型号",longitude STRING COMMENT "位置经度",latitude STRING COMMENT "位置纬度",ip STRING COMMENT "客户端IP信息",login STRING COMMENT "是否登录用户",report_src STRING COMMENT "上报来源类型",scene_id STRING COMMENT "场景ID",user_id STRING COMMENT "用户ID",item_id STRING COMMENT "内容ID",item_type STRING COMMENT "内容的类型",module_id STRING COMMENT "模块ID",page_id STRING COMMENT "页面ID",position STRING COMMENT "内容所在的位置信息",bhv_type STRING COMMENT "行为类型",bhv_value STRING COMMENT "行为详情",bhv_time STRING COMMENT "行为发生的时间戳")PARTITIONED BY (ds STRING)LIFECYCLE 30;

CREATE TABLE IF NOT EXISTS item_news (item_id STRING COMMENT '内容唯一标识ID',item_type STRING COMMENT '内容的类型',title STRING COMMENT '内容标题',content STRING COMMENT '内容简介',user_id STRING COMMENT '发布用户ID',pub_time STRING COMMENT '发布时间',status STRING COMMENT '是否可推荐',expire_time STRING COMMENT '内容失效时间戳，单位s',last_modify_time STRING COMMENT '内容信息的最后修改时间戳，单位s',scene_id STRING COMMENT '场景ID',duration STRING COMMENT '时长，秒',category_level STRING COMMENT '类目层级数，例如3级类目',category_path STRING COMMENT '类目路径，下划线联接',tags STRING COMMENT '标签，多个标签使用英文逗号分隔',channel STRING COMMENT '频道，多个标签使用英文逗号分隔',organization STRING COMMENT '机构列表，多个标签使用英文逗号分隔',author STRING COMMENT '作者列表，多个标签使用英文逗号分隔',pv_cnt STRING COMMENT '一个月内曝光次数',click_cnt STRING COMMENT '一个月内点击次数',like_cnt STRING COMMENT '一个月内点赞次数',unlike_cnt STRING COMMENT '一个月内踩次数',comment_cnt STRING COMMENT '一个月内评论次数',collect_cnt STRING COMMENT '一个月内收藏次数',share_cnt STRING COMMENT '一个月内分享次数',download_cnt STRING COMMENT '一个月内下载次数',tip_cnt STRING COMMENT '一个月内打赏数',subscribe_cnt STRING COMMENT '一个月内关注数',source_id STRING COMMENT '物料经由哪个平台进入场景',country STRING COMMENT '国家编码',city STRING COMMENT '城市名称',features STRING COMMENT '物料离散特征',num_features STRING COMMENT '物料连续特征',weight STRING COMMENT 'item加权权重1-10000')PARTITIONED BY (ds STRING)LIFECYCLE 30;
试用


CREATE TABLE IF NOT EXISTS user_news (user_id STRING COMMENT "用户唯一ID",user_id_type STRING COMMENT "用户注册类型",third_user_name STRING COMMENT "第三方用户名称",third_user_type STRING COMMENT "第三方平台名称",phone_md5 STRING COMMENT "用户手机号的md5值",imei STRING COMMENT "用户设备ID",content STRING COMMENT "用户内容",gender STRING COMMENT "性别",age STRING COMMENT "年龄",age_group STRING COMMENT "年龄段",country STRING COMMENT "国家",city STRING COMMENT "城市",ip STRING COMMENT "最后登录IP",device_model STRING COMMENT "设备型号",register_time STRING COMMENT "注册时间戳",last_login_time STRING COMMENT "上次登录时间戳",last_modify_time STRING COMMENT "用户信息的最后修改时间戳",tags STRING COMMENT "用户tags",source STRING,features STRING,num_features STRING)PARTITIONED BY (ds STRING)LIFECYCLE 30;

```
