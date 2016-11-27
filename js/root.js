new Vue({
    el:"#xjw",
    data:{
        isAdmin: false,
        user: {
            name: '',
            id: '',
            telephone: '',
            user_type: '',
            user_frozen: ''
        },
        iS_text: ''
    },
    ready: function(){
        var vm = this;
        this.$http.get('./php/isLogin.php').then(function(resp){
            if(resp.body.admin === true){
                vm.isAdmin = true;
                vm.user.name = resp.body.username;
                vm.user.id = resp.body.userid;
                vm.user.telephone = resp.body.phone;
                vm.user.user_type = resp.body.user_type;
                vm.user.user_frozen = resp.body.frozen;
            }else{
                vm.isAdmin = false;
            }
        },function(err){

        });
    },
    events:{
        call: function(msg){
            this.user.telephone = msg.phone;
            this.user.user_type = msg.user_type;
            this.user.user_frozen = msg.frozen;
        },
        callAdmin: function(msg){
            this.isAdmin = msg.ad;
        },
        callUser: function(msg){
            this.user.name = msg.user;
        },
        callId: function(msg){
            this.user.id = msg.id;
        },
        clear: function(){
            this.$refs.iSearch.listData = [];
            this.$refs.iSearch.searchVal = '';
            this.$refs.iList.items = [];
            this.$refs.iList.$set('index',1);
            this.$refs.iList.$set('maxIndex','');
        }
    },
    methods: {
        icon_search: function(){
            this.$refs.iSearch.Search(this.iS_text);
            this.iS_text = '';
        }
    }
})