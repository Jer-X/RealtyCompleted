new Vue({
    el:"#xjw",
    data:{
        isAdmin: false,
        user: {
            name: '',
            id: ''
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
            }else{
                vm.isAdmin = false;
            }
        },function(err){

        });
    },
    events:{
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
        }
    },
    methods: {
        icon_search: function(){
            this.$refs.iSearch.Search(this.iS_text);
            this.iS_text = '';
        }
    }
})