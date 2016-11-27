Vue.component('x-search',{
	template: `
		<div class="mdl-cell--12-col">
			<div class="mdl-cell--4-col mdl-cell--4-offset" v-bind:class="[ (listData != '') ? '' : 'search-box']">
				<div class="demo-list-action mdl-list">
					<div class="mdl-list__item">
						<span class="mdl-list__item-primary-content">
							<i class="material-icons  mdl-list__item-icon">search</i>
							<select v-model="selected" class="select">
								<option value="1" selected>标题</option>
								<option value="2">面积</option>
								<option value="3">装修</option>
								<option value="4">居室</option>
								<option value="5">地址</option>
								<option value="6">售价</option>
							</select>
							<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label text-length">
								<input class="mdl-textfield__input" id="Search" v-model="searchVal" @keydown.enter="Search()"> 
								<label class="mdl-textfield__label" for="Search">搜索内容</label>
							</div>
							<button class="mdl-button mdl-js-button search-btn" v-on:click="Search()">
								搜索
							</button>
						</span>
					</div>
				</div>
			</div>
			<table v-if=" listData != '' " class="mdl-data-table mdl-js-data-table mdl-shadow--2dp mdl-cell--12-col">
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
					<tr v-for="item in listData">
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
		</div>	
	`,
	data: function(){
		return {
			searchVal: '',
			listData: [],
			type: ['出售','出租','求购','求租','合租'],
			source: ['个人','中介'],
			selected: ''
		};
	},
	methods: {
		Search: function(){
			//console.log(obj.searchVal);
			var _this = this;
			if(_this.searchVal == ''){
				alert('请输入关键词');
				return;
			}
			if (!_this.$parent.isAdmin) {
				alert('登录才能搜索！');
				return false;
			}
			this.$http.post('./php/search.php', { 'key':_this.searchVal,'type':_this.selected },{ emulateJSON:true } ).then(function(msg){
			// console.log(msg.body, typeof msg.body);
				if(msg.body.length != 0){
					_this.listData = JSON.parse(msg.body);
				}else{
					alert('查无数据');
				}
				
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
				}else{
					alert('你已经投诉过了');
				}
			},function(err){});
			this.$http.post('./php/judge_com.php',{ e_id: eid },{ emulateJSON: true });
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