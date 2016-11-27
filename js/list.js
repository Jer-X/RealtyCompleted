Vue.component('x-list',{
	template: `
		<div class="mdl-cell--12-col">
			<button v-if=" items == '' " class="mdl-button mdl-js-button mdl-button--raised mdl-cell--2-col mdl-cell--5-offset" v-on:click="Getdata">
				<i class="material-icons">refresh</i>
			</button>
			<div v-if=" items != '' " class="mdl-cell--5-offset mdl-cell--2-col" id="top">
				<button class="mdl-button mdl-js-button mdl-button--raised mdl-cell--6-col" @click="pageChange(0)">
					<i class="material-icons">keyboard_arrow_left</i>
				</button>
				<button class="mdl-button mdl-js-button mdl-button--raised mdl-cell--6-col" @click="pageChange(1)">
					<i class="material-icons">keyboard_arrow_right</i>
				</button>
			</div>
			<table v-if=" items != '' " class="mdl-data-table mdl-js-data-table mdl-shadow--2dp mdl-cell--12-col margin_5">
				<thead>
					<tr>
						<th class="mdl-data-table__cell--non-numeric">图片</th>
						<th class="mdl-data-table__cell--non-numeric">标题</th>
						<th class="mdl-data-table__cell--non-numeric">面积</th>
						<th class="mdl-data-table__cell--non-numeric">装修</th>
						<th class="mdl-data-table__cell--non-numeric">居室</th>
						<th class="mdl-data-table__cell--non-numeric">地址</th>
						<th class="mdl-data-table__cell--non-numeric">售价</th>
						<th class="mdl-data-table__cell--non-numeric">类型</th>
						<th class="mdl-data-table__cell--non-numeric">房主</th>
						<th class="mdl-data-table__cell--non-numeric">时间</th>
						<th class="mdl-data-table__cell--non-numeric">来源</th>
						<th class="mdl-data-table__cell--non-numeric">投诉</th>
					</tr>
				</thead>
				<tbody>
					<tr v-for="item in items">
						<td class="mdl-data-table__cell--non-numeric"><img class="image" v-bind:src="item.image"></td>
						<td class="mdl-data-table__cell--non-numeric">{{ item.title }}</td>
						<td class="mdl-data-table__cell--non-numeric">{{ item.area }}</td>
						<td class="mdl-data-table__cell--non-numeric">{{ item.decorate }}</td>
						<td class="mdl-data-table__cell--non-numeric">{{ item.construct }}</td>
						<td class="mdl-data-table__cell--non-numeric">{{ item.address }}</td>
						<td class="mdl-data-table__cell--non-numeric">{{ item.price }}</td>
						<td class="mdl-data-table__cell--non-numeric">{{ type[item.info_type - 1] }}</td>
						<td class="mdl-data-table__cell--non-numeric">{{ item.username }}</td>
						<td class="mdl-data-table__cell--non-numeric">{{ item.create_time }}</td>
						<td class="mdl-data-table__cell--non-numeric">{{ source[item.user_type] }}</td>
						<td class="mdl-data-table__cell--non-numeric">
							<button class="mdl-button mdl-js-button mdl-button--icon mdl-button--colored" @click="Complaint(item.eid,userid)">
							  <i class="material-icons">report</i>
							</button>
						</td>
					</tr>
				</tbody>
			</table>
			<a v-if=" items != '' " class="topBack" href="#top">
				<i class="material-icons Font">keyboard_arrow_up</i>
			</a>
		</div>
	`,
	data: function(){
		return {
			items: [],
			type: ['出售','出租','求购','求租','合租'],
			source: ['个人','中介'],
			index: 1,
			maxIndex: ''
		};
	},
	methods: {
		pageChange: function(msg){
			if(msg == 0){
				if(this.index == 1){
					alert('已经是第一页了!');
					return;
				}
				this.$set('index',this.index-1);
				this.$http.post('./php/list.php',{
					index: this.index
				},{ emulateJSON:true }).then(function(msg){
					this.items = msg.body;
				},function(err){
					console.log(err);
				});
			}
			if(msg == 1){
				if(this.index == this.maxIndex){
					alert('已经是最后一页了!');
					return;
				}
				this.$set('index',this.index+1);
				this.$http.post('./php/list.php',{
					index: this.index
				},{ emulateJSON:true }).then(function(msg){
					this.items = msg.body;
				},function(err){
					console.log(err);
				});
			}
		},
		Getdata: function(){
			if (!this.$parent.isAdmin) {
				alert('登录才能刷新！');
				return false;
			}
			this.$http.post('./php/list.php',{
				index: this.index
			},{ emulateJSON:true }).then(function(msg){
				this.items = msg.body;
				this.$http.get('./php/maxPage.php').then(function(msg){
					this.maxIndex = msg.body;
				});
			},function(err){
				console.log(err);
			});
		},
		Complaint: function(eid,uid){
			var _this = this;
			this.$http.post('./php/complaint.php',{ 
				u_id: uid,
				e_id: eid
			},{ emulateJSON:true }).then(function(msg){
				if(msg.body.code === 200 ){
					alert('投诉成功');
					this.$http.post('./php/judge_com.php',{ e_id: eid },{ emulateJSON: true });
				}else if(msg.body.code === 400 ){
					alert('你已经投诉过了');
				}else{
					alert('不能投诉自己');
				}
			},function(err){});
		}
	},
	computed: {
		userid: {
			get: function(){
				return this.$parent.user.id;
			}
		}
	}
})
