import{_ as h,a as v,b as c}from"./ResponsiveNavLink-3932dd1a.js";import{r as b,o as n,c as m,l as p,f as i,u as d,b as e,a as o,w as t,z as x,g as r,t as l,n as f,D as _}from"./app-db97278d.js";import{u as k}from"./notification-acac295e.js";import{_ as y}from"./FlashMessage-f6516a28.js";import w from"./CustomSidebar-7abc467c.js";const $={class:"min-h-screen bg-white dark:bg-gray-900"},M={class:"bg-gray-200 dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700"},B={class:"max-w-7xl mx-auto px-4 sm:px-6 lg:px-8"},C={class:"flex justify-between h-16"},N={class:"flex"},L={class:"shrink-0 flex items-center"},S=e("div",{class:"text-xl text-black font-semibold"}," Fifty-Fifty ",-1),j={class:"hidden sm:flex sm:items-center sm:ml-6"},A={class:"ml-3 relative"},D={class:"inline-flex rounded-md"},V={class:"inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none transition ease-in-out duration-150",type:"button"},z=e("svg",{class:"ml-2 -mr-0.5 h-4 w-4",fill:"currentColor",viewBox:"0 0 20 20",xmlns:"http://www.w3.org/2000/svg"},[e("path",{"clip-rule":"evenodd",d:"M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z","fill-rule":"evenodd"})],-1),F={class:"-mr-2 flex items-center sm:hidden"},O={class:"h-6 w-6",fill:"none",stroke:"currentColor",viewBox:"0 0 24 24"},E={class:"pt-2 pb-3 space-y-1"},P={class:"pt-4 pb-1 border-t border-gray-200 dark:border-gray-600"},T={class:"px-4"},q={class:"font-medium text-base text-gray-800 dark:text-gray-200"},G={class:"font-medium text-sm text-gray-500"},H={class:"mt-3 space-y-1"},I={key:0,class:"bg-white dark:bg-gray-800 shadow"},J={class:"max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8"},K={class:"flex flex-wrap md:flex-nowrap"},ee={__name:"AdminLayout",setup(Q){const a=b(!1),u=k();return(s,g)=>(n(),m("div",null,[s.$page.props.flash.message?(n(),p(y,{key:0,message:s.$page.props.flash.message.content,type:s.$page.props.flash.message.type},null,8,["message","type"])):i("",!0),d(u).isShown?(n(),p(y,{key:1,message:d(u).message,type:d(u).type},null,8,["message","type"])):i("",!0),e("div",$,[e("nav",M,[e("div",B,[e("div",C,[e("div",N,[e("div",L,[o(d(x),{href:s.route("dashboard")},{default:t(()=>[S]),_:1},8,["href"])])]),e("div",j,[e("div",A,[o(v,{align:"right",width:"48"},{trigger:t(()=>[e("span",D,[e("button",V,[r(l(s.$page.props.auth.user.first_name)+" "+l(s.$page.props.auth.user.last_name)+" ",1),z])])]),content:t(()=>[o(h,{href:s.route("profile.edit")},{default:t(()=>[r("My Account")]),_:1},8,["href"]),s.$page.props.auth.user.can_access_admin?(n(),p(h,{key:0,href:s.route("admin.panel.page")},{default:t(()=>[r(" Admin Panel ")]),_:1},8,["href"])):i("",!0),o(h,{href:s.route("logout"),as:"button",method:"post"},{default:t(()=>[r(" Log Out ")]),_:1},8,["href"])]),_:1})])]),e("div",F,[e("button",{class:"inline-flex items-center justify-center p-2 rounded-md text-gray-400 dark:text-gray-500 hover:text-gray-500 dark:hover:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-900 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-900 focus:text-gray-500 dark:focus:text-gray-400 transition duration-150 ease-in-out",onClick:g[0]||(g[0]=R=>a.value=!a.value)},[(n(),m("svg",O,[e("path",{class:f({hidden:a.value,"inline-flex":!a.value}),d:"M4 6h16M4 12h16M4 18h16","stroke-linecap":"round","stroke-linejoin":"round","stroke-width":"2"},null,2),e("path",{class:f({hidden:!a.value,"inline-flex":a.value}),d:"M6 18L18 6M6 6l12 12","stroke-linecap":"round","stroke-linejoin":"round","stroke-width":"2"},null,2)]))])])])]),e("div",{class:f([{block:a.value,hidden:!a.value},"sm:hidden"])},[e("div",E,[o(c,{active:s.route().current("dashboard"),href:s.route("dashboard")},{default:t(()=>[r(" Dashboard ")]),_:1},8,["active","href"])]),e("div",P,[e("div",T,[e("div",q,l(s.$page.props.auth.user.name),1),e("div",G,l(s.$page.props.auth.user.email),1)]),e("div",H,[o(c,{href:s.route("profile.edit")},{default:t(()=>[r(" My Account")]),_:1},8,["href"]),o(c,{href:s.route("logout"),as:"button",method:"post"},{default:t(()=>[r(" Log Out ")]),_:1},8,["href"])])])],2)]),s.$slots.header?(n(),m("header",I,[e("div",J,[_(s.$slots,"header")])])):i("",!0),e("main",K,[o(w),_(s.$slots,"default")])])]))}};export{ee as _};