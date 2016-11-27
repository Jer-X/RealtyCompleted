Vue.component('x-card',{
	data: function(){
		return {
			
		}
	},
	template: `
		<div class="mdl-cell--12-col">
			<msg></msg>
			<tip v-ref:tips></tip>
		</div>
	`,
	events: {
		callTips: function(message){
            this.$refs.tips.callTip(message);
        }
	},
	components: {
		'tip': {
            template: `
                <div class="mdl-js-snackbar mdl-snackbar">
                  <div class="mdl-snackbar__text"></div>
                  <button class="mdl-snackbar__action" type="button"></button>
                </div>
            `,
            methods: {
                callTip: function(data){
                    if (!data || !data.message) {
                        return false;
                    }
                    this.$el.MaterialSnackbar.showSnackbar(data);
                }
            }
        },
        'msg': {
        	data: function(){
        		return {
        			Info: ['Sales Info','Rental Info','Buying Info','HouseRental Info','Co-tenant Info'],
					Pric: ['售价','出租价','求购价','求租价','合租价'],
					index: 1,
					msgTitle: '',
					msgAddress: '',
					msgArea: '',
					msgDecorate: '',
					msgPrice: '',
					msgConstruct: '',
					msgPhoto: ''
        		};
        	},
        	template: `
				<div class="mdl-tabs mdl-js-tabs mdl-js-ripple-effect mdl-cell--6-col mdl-cell--3-offset">
					<div class="mdl-tabs__tab-bar">
						<a href="#panel" class="mdl-tabs__tab is-active" v-on:click="Click(1)">出售</a>
						<a href="#panel" class="mdl-tabs__tab" v-on:click="Click(2)">出租</a>
						<a href="#panel" class="mdl-tabs__tab" v-on:click="Click(3)">求购</a>
						<a href="#panel" class="mdl-tabs__tab" v-on:click="Click(4)">求租</a>
						<a href="#panel" class="mdl-tabs__tab" v-on:click="Click(5)">合租</a>
					</div>
					<!-- panel -->
					<div class="mdl-tabs__panel mdl-grid is-active" id="panel">
						<div class="demo-card-wide mdl-card mdl-shadow--2dp mdl-cell--8-col mdl-cell--2-offset">
							<div class="mdl-card__title">
								<h2 class="mdl-card__title-text">{{ Info[index-1] }}</h2>
							</div>
							<div class="mdl-card__supporting-text mdl-grid">
								<ul class="demo-list-icon mdl-list mdl-cell--10-col mdl-cell--1-offset">
									<li class="mdl-list__item padding-notop">
										<span class="mdl-list__item-primary-content">
											<i class="material-icons mdl-list__item-icon">title</i>
											<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
												<input class="mdl-textfield__input" type="text" id="sample7" v-model="msgTitle">
												<label class="mdl-textfield__label" for="sample7">标题</label>
											</div>
										</span>
									</li>
									<li class="mdl-list__item padding-notop">
										<span class="mdl-list__item-primary-content">
											<i class="material-icons mdl-list__item-icon">streetview</i>
											<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
												<input class="mdl-textfield__input" type="text" id="sample9" v-model="msgAddress">
												<label class="mdl-textfield__label" for="sample9">房源地址</label>
											</div>
										</span>
									</li>
									<li class="mdl-list__item padding-notop">
										<span class="mdl-list__item-primary-content">
											<i class="material-icons mdl-list__item-icon">domain</i>
											<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
												<input class="mdl-textfield__input" type="text" id="sample11" v-model="msgArea">
												<label class="mdl-textfield__label" for="sample11">面积</label>
											</div>
										</span>
									</li>
									<li class="mdl-list__item padding-notop">
										<span class="mdl-list__item-primary-content">
											<i class="material-icons mdl-list__item-icon">apps</i>
											<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
												<input class="mdl-textfield__input" type="text" id="sample12" v-model="msgConstruct">
												<label class="mdl-textfield__label" for="sample12">户型</label>
											</div>
										</span>
									</li>
									<li class="mdl-list__item padding-notop">
										<span class="mdl-list__item-primary-content">
											<i class="material-icons mdl-list__item-icon">attach_money</i>
											<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
												<input class="mdl-textfield__input" type="text" id="sample13" v-model="msgPrice">
												<label class="mdl-textfield__label" for="sample13">{{ Pric[index-1] }}</label>
											</div>
										</span>
									</li>
									<li class="mdl-list__item padding-notop">
										<span class="mdl-list__item-primary-content">
											<i class="material-icons mdl-list__item-icon">image</i>
											<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
												<input class="mdl-textfield__input" id="up_img" type="file" id="sample15" v-model="msgPhoto">
											</div>
										</span>
									</li>
									<li v-show="index == 1 || index == 3" class="mdl-list__item padding-notop">
										<span class="mdl-list__item-primary-content">
											<i class="material-icons mdl-list__item-icon">link</i>
											<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
												<input class="mdl-textfield__input" type="text" id="sample14" v-model="msgDecorate">
												<label class="mdl-textfield__label" for="sample14">装修</label>
											</div>
										</span>
									</li>
								</ul>
							</div>
							<div class="mdl-card__actions mdl-card--border mdl-grid">
								<!-- Accent-colored flat button -->
								<div class="mdl-cell--4-col mdl-cell--4-offset">
									<button class="mdl-button mdl-js-button mdl-button--accent " type="submit" @click="Send">
										COMMIT
									</button>
									<button class="mdl-button mdl-js-button mdl-button--accent " type="reset">
										RESET
									</button>
								</div>
							</div>
							<div class="mdl-card__menu">
								<button class="mdl-button mdl-button--icon mdl-js-button mdl-js-ripple-effect">
									<i class="material-icons">share</i>
								</button>
							</div>
						</div>
					</div>
				</div>
        	`,
        	computed: {
        		userid: {
        			get: function(){
        				return this.$parent.$parent.user.id;
        			}
        		},
        		msgImage: {
        			get: function(){
        				return document.querySelector('#up_img').files[0];
        			}
        		}
        	},
        	methods: {
				Click: function(num){
					this.index = num
				},
				Send: function(){
					_this = this;
					if (!_this.$parent.$parent.isAdmin) {
		                _this.$dispatch('callTips', { message: '登录才能发布信息!' });
		                return false;
		            }

		            if(_this.msgTitle == '' 
		            || _this.msgArea == ''
		            || _this.msgConstruct == ''
		            || _this.msgAddress == ''
		            || _this.msgPrice == ''
		            || _this.msgPhoto == ''){
		                _this.$dispatch('callTips', { message: '信息不完整~' });
		                return false;
		            }
		            
		            if(_this.$root.user.user_frozen == 1){
		            	_this.$dispatch('callTips', { message: '账号已冻结!' });
		                return false;
		            }

		            _this.$http.post('./php/insertMsg.php', {
		            	uid: _this.userid,
		            	type: '1',
		                msgType: _this.index,
		                msgTitle: _this.msgTitle,
		                msgArea: _this.msgArea,
		                msgDecorate: _this.msgDecorate,
		                msgAddress: _this.msgAddress,
		                msgPrice: _this.msgPrice,
		                msgConstruct: _this.msgConstruct
		            }, { emulateJSON: true }).then(function (result) {
		                if (result.body.code === 200) {
		                 	var fd = new FormData();
						    fd.append("eid", result.body.eid);
						    fd.append("upfile", _this.msgImage);
						    _this.$http.post('./php/insertMsg.php',fd,{ emulateJSON: true }).then(function(respon){
						    	if (respon.body.code === 200) {
						    		_this.$dispatch('callTips', { message: '发布成功啦~' });
				                    _this.msgTitle = '';
				                    _this.msgArea = '';
				                    _this.msgDecorate = '';
				                    _this.msgAddress = '';
				                    _this.msgPrice = '';
				                    _this.msgConstruct = '';
				                    document.querySelector('#up_img').value = '';
				                    _this.$dispatch('callData',{ message: '修改'});
				                    _this.$http.post('./php/judge.php',{ uid: _this.userid },{ emulateJSON: true }).then(function(msg){
				                    	if(msg.body == 201 || msg.body == 202 || msg.body == 201202){
				                    		_this.$root.refresh();
				                    	}
				                    });
						    	}else{
						    		_this.$dispatch('callTips', { message: '图片上传不成功！' });
						    	}
						    },function(err){});
		                } else {
		                    _this.$dispatch('callTips', { message: '数据库已挂！' });
		                }
		            }, function (err) {});
				}
			},

        }
	}
})
