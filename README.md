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
![alt](/images/airec_dataflow.png)

