"use strict";(self["webpackChunk"]=self["webpackChunk"]||[]).push([[795],{4795:function(e,t,a){a.r(t),a.d(t,{default:function(){return w}});var o=a(9199);const s=e=>((0,o.pushScopeId)("data-v-38262fde"),e=e(),(0,o.popScopeId)(),e),n={class:"authincation h-100"},r={class:"container h-100"},c={class:"row justify-content-center h-100 align-items-center"},d={class:"col-md-6"},l={class:"authincation-content"},i={class:"row no-gutters"},h={class:"col-xl-12"},u={class:"auth-form"},m=s((()=>(0,o.createElementVNode)("div",{class:"text-center mb-3"},[(0,o.createElementVNode)("img",{src:"images/logo.jpg",alt:""})],-1))),p=s((()=>(0,o.createElementVNode)("h4",{class:"text-center mb-4"},"Auto Login to your account",-1))),v={class:"new-account mt-5"},N=s((()=>(0,o.createElementVNode)("br",null,null,-1)));function V(e,t,a,s,V,g){const E=(0,o.resolveComponent)("router-link"),f=(0,o.resolveComponent)("b-button");return(0,o.openBlock)(),(0,o.createElementBlock)("div",n,[(0,o.createElementVNode)("div",r,[(0,o.createElementVNode)("div",c,[(0,o.createElementVNode)("div",d,[(0,o.createElementVNode)("div",l,[(0,o.createElementVNode)("div",i,[(0,o.createElementVNode)("div",h,[(0,o.createElementVNode)("div",u,[m,p,(0,o.createElementVNode)("div",v,[(0,o.createElementVNode)("p",null,[(0,o.createTextVNode)(" Don't have an account? "),N,(0,o.createVNode)(f,{variant:"success"},{default:(0,o.withCtx)((()=>[(0,o.createVNode)(E,{to:"/register",class:"text-white"},{default:(0,o.withCtx)((()=>[(0,o.createTextVNode)("CREATE ACCOUNT")])),_:1})])),_:1})])])])])])])])])])])}a(560);var g={mounted:function(){this.$store.state.token||this.$store.dispatch("auth/getUser",{that:this})},watch:{"$store.state.auth.token":{immediate:!0,handler(){this.$store.getters["auth/loggedIn"]&&(this.$store.dispatch("auth/getUser",{that:this}),window.is_frontend?this.$router.push("/dashboard"):this.$router.push("/manage/dashboard"))}}},data:()=>({loading:!1,model:{username:"",password:""}}),methods:{login(){let e={username:this.model.username,password:this.model.password,that:this};this.$store.dispatch("auth/authenticate",e)}}},E=a(89);const f=(0,E.Z)(g,[["render",V],["__scopeId","data-v-38262fde"]]);var w=f}}]);
//# sourceMappingURL=795.js.map