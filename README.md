# Realty
一.题目
    使用PHP和MySQL，实现一个房产信息网站。

二.功能要求：
    设计开发一个房产信息网站， 需要有如下功能：

房产网站框架与页面组成：

房产网站
  ├-搜索主页
=============
       ├-搜索结果列表页—房源详细信息页—网上房源展示页--投诉建议页
  ├-登陆注册
=============
       ├-(登陆) --留言信息(如有) --帐号管理
       ├-(注册) --注册页面
  ├-信息发布
=============
       ├-发布出售信息
       ├-发布出租信息
       ├-发布求购信息
       ├-发布求租信息
       ├-发布合租信息

*  搜索主页
    搜索主页是网站的入口页。入口页里面不需要做太多内容，风格像百度的主页那样简单风格就可以了。
*  搜索结果列表页和房源信息详细页
    搜出来的房屋信息条目中， 要有一列（或有个图标）说明房屋网上展示方式。 房屋网上展示方式有三种： 图片、全景图或3D场景。全景图和3D场景的房源至少各有一个（可以使用以前的其他课程的作业作品）。
    搜索结果页上每条信息都要有一个字段标明该信息是个人信息还是中介信息。
*  发布**信息页及数据库
    要有信息真实性和发布者身份的判断功能，要求能基本判断信息发布者发布的信息是否真假，并能判断信息发布者是个人还是中介人员。判别信息的基本原则和方法有如下：
    *  如果发布者一个月内发布了5条以上的信息，可知改用户是中介人员（个人用户一般没这么多房源），记入数据库。
    *  如果一个月内有10条以上的信息有不同房源地址但却有相同的联系方式，这些信息的发布者是中介人员，记入数据库。
    *  如果一条信息被3个以上不同的用户投诉，则判断该信息为假信息，记入数据库。对该信息的发布者封杀一个月，并撤下该发布者一个月内发布的所有信息（不要让搜索结果列表页搜到）
    *  数据库要有300条以上的记录，并有数据支持上文各功能点的测试。