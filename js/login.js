Vue.component('x-login',{
	data: function(){
		return {		
		};
	},
	template: `
		<div class="mdl-cell--12-col">
          <div v-show="!isAdmin">
            <login></login>
          </div>
          <div>
            <info v-show="isAdmin"></info>
          </div>
          <tip v-ref:tips></tip>
        </div>
	`,
    events: {
        callTips: function(message){
            this.$refs.tips.callTip(message);
        }
    },
    computed: {
        isAdmin: {
            get: function () {
                return this.$parent.isAdmin;
            }
        },
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
        'login': {
            data: function(){
                return {
                    checked: false,
                    username: '',
                    password: '',
                    Spassword: '',
                    telephone: ''
                };
            },
            template: `
                <div class="mdl-cell--5-offset mdl-cell--2-col demo-card-wide mdl-card mdl-shadow--2dp">
                    <div class="mdl-card__title">
                        <h4 v-if="checked" class="mdl-card__title-text">Please Login Up</h4>
                        <h4 v-if="!checked" class="mdl-card__title-text">Please Sign Up</h4>
                    </div>
                    <div class="mdl-card__supporting-text">
                        <label class="mdl-switch mdl-js-switch mdl-js-ripple-effect" for="switch-1">
                            <input type="checkbox" id="switch-1" class="mdl-switch__input" v-model="checked">
                            <span v-if="!checked" class="mdl-switch__label">登录</span>
                            <span v-if="checked" class="mdl-switch__label">注册</span>
                        </label>
                        <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label" >
                            <input class="mdl-textfield__input" type="text" pattern="^([a-zA-Z0-9_-])+@([a-zA-Z0-9_-])+((\.[a-zA-Z0-9_-]{2,3}){1,2})$" id="sample1" v-model="username">
                            <label class="mdl-textfield__label" for="sample1">Email address</label>
                            <span class="mdl-textfield__error">Please enter a valid email address</span>
                        </div>
                        <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                            <input class="mdl-textfield__input" type="password" pattern="[A-Za-z0-9\-]+" id="sample2" v-model="password">
                            <label class="mdl-textfield__label" for="sample2">Password</label>
                            <span class="mdl-textfield__error">Input only accept a-z,0-9,- !</span>
                        </div>
                        <div v-show="!checked" class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                            <input class="mdl-textfield__input" type="password" pattern="[A-Za-z0-9\-]+" id="sample5" v-model="Spassword">
                            <label class="mdl-textfield__label" for="sample5">Password Again</label>
                            <span class="mdl-textfield__error">Input only accept a-z,0-9,- !</span>
                        </div>
                        <div v-show="!checked" class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                            <input class="mdl-textfield__input" type="text" pattern="[0-9]{11}" id="sample4"  v-model="telephone">
                            <label class="mdl-textfield__label" for="sample4">Telephpne Number</label>
                            <span class="mdl-textfield__error">Input only accept eleven numbers->(0-9) !</span>
                        </div>
                    </div>
                    <div class="mdl-card__actions mdl-card--border">
                        <button class="mdl-button mdl-js-button mdl-js-ripple-effect mdl-cell--4-offset" @click="commit">
                            commit
                        </button>
                    </div>
                    <div class="mdl-card__menu">
                        <button class="mdl-button mdl-button--icon mdl-js-button mdl-js-ripple-effect">
                          <i class="material-icons">share</i>
                        </button>
                    </div>
                </div>
            `,
            methods: {
                commit: function(){
                    if(this.checked == false){
                        var _this = this;
                        if(this.password =='' || this.Spassword==''){
                            _this.$dispatch('callTips', {message: '请输入密码'});
                            return false;
                        }
                        if(this.Spassword != this.password){
                            _this.$dispatch('callTips', {message: '两次密码输入不一致'});
                            return false;
                        }
                        this.$http.post('./php/sign.php',{
                            username : _this.username,
                            password : _this.password,
                            telephone : _this.telephone
                        },{ emulateJSON : true }).then(function(result){
                            if(result.body.code === 204){
                                _this.$dispatch('callTips', {message: '该用户名已注册'});
                                return false;
                            }else if(result.body.code === 404){
                                _this.$dispatch('callTips', {message: '服务器出错了(⊙o⊙)…'});
                                return false;
                            }else{
                                _this.$dispatch('callTips', {message: '注册成功！'});
                                _this.$dispatch('callAdmin', { ad : true });
                                _this.$dispatch('callId', { id : result.body.uid });
                                //console.log(result.body.username);
                                _this.$dispatch('callUser', { user : result.body.username });
                                _this.username = '';
                                _this.password = '';
                                _this.Spassword = '';
                                _this.telephone = '';
                            }
                            
                        },function(err){});
                    }else{
                        var _this = this;
                        _this.$http.post('./php/login.php',{
                            username : _this.username,
                            password : _this.password
                        },{ emulateJSON : true }).then(function(result){
                            if (result.body.code === 200){
                                _this.$dispatch('callTips', {message: '登录成功，继续使用'});
                                _this.$dispatch('callAdmin', { ad : true });
                                _this.$dispatch('callId', { id : result.body.uid });
                                _this.$dispatch('callUser', { user : result.body.username });
                                _this.username = '';
                                _this.password = '';
                            }else if(result.body.code === 100){
                                _this.$dispatch('callTips', {message: '该用户未注册，请核对！'});
                            }else{
                                _this.$dispatch('callTips', {message: '登录失败，请核对账户密码'});
                            }
                        },function(err){
                            _this.$dispatch('callTips', {message: '网络错误'});
                        });   
                    }
                    
                }
            }
        },
        'info': {
            template: `
                <div class="mdl-cell--4-offset mdl-cell--4-col demo-card-wide mdl-card mdl-shadow--2dp">
                  <div class="mdl-card__title">
                    <h2 class="mdl-card__title-text">个人主页</h2>
                  </div>
                  <div class="mdl-card__supporting-text">
                    <ul class="demo-list-icon mdl-list">
                        <li class="mdl-list__item">
                            <span class="mdl-list__item-primary-content">
                                <i class="material-icons mdl-list__item-icon">account_circle</i>
                                账号 - {{username}}
                            </span>
                        </li>
                    </ul>
                  </div>
                  <div class="mdl-card__actions mdl-card--border mdl-grid">
                    <a @click="Quit" class="mdl-cell--5-offset mel-cell-2-col mdl-button mdl-button--colored mdl-js-button mdl-js-ripple-effect">
                        退出登录
                    </a>
                  </div>
                  <div class="mdl-card__menu">
                    <button class="mdl-button mdl-button--icon mdl-js-button mdl-js-ripple-effect">
                      <i class="material-icons">explore</i>
                    </button>
                  </div>
                </div>
            `,
            computed: {
                username: {
                    get: function(){
                        return this.$parent.$parent.user.name;
                    }
                }
            },
            methods: {
                Quit: function(){
                    var _this = this;
                    this.$http.get('./php/quit.php').then(function(result){
                        _this.$dispatch('callTips', {message: '退出成功！'});
                        _this.$dispatch('callAdmin', { ad : false });
                        _this.$dispatch('callUser', { user : '' }); 
                        _this.$dispatch('clear');
                    },function(err){});
                }
            }
        }
    }
})