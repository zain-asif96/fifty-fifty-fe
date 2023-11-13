import{r as h,d as $,c as _,a as m,w as y,u as t,F as k,o as f,Z as S,b as e,t as o,i as V,e as P,f as R,n as b,g as d,h as I,z as q,O as v,p as N,j}from"./app-db97278d.js";import{_ as B}from"./AdminLayout-8e0f8360.js";import{P as O}from"./Pagination-e186959c.js";import{u as K}from"./sorting-acdd0b76.js";import{_ as L}from"./TextInput-23d29fe4.js";import{_ as U}from"./_plugin-vue_export-helper-c27b6911.js";import"./ResponsiveNavLink-3932dd1a.js";import"./notification-acac295e.js";import"./FlashMessage-f6516a28.js";import"./CustomSidebar-7abc467c.js";import"./SidebarElement-2b51bfcd.js";const w=u=>(N("data-v-de0afa71"),u=u(),j(),u),z=w(()=>e("title",null,`
            Receivers
        `,-1)),E={class:"ml-4 md:ml-16"},F={class:"mt-16 mb-8 text-xl flex items-center justify-between"},D=w(()=>e("div",null," Receivers ",-1)),M={class:"text-sm"},T={class:"flex items-end gap-3"},Z={class:"relative overflow-x-auto shadow-md sm:rounded-lg"},A={class:"w-full text-sm text-left text-gray-500 dark:text-gray-400"},G={class:"text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400"},H={class:"fw-100"},J={class:"fw-100"},Q={class:"fw-100"},W={class:"fw-100"},X={class:"fw-100"},Y={class:"px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white",scope:"row"},ee={class:"px-6 py-4"},te={class:"px-6 py-4"},se={class:"px-6 py-4"},ae={class:"px-6 py-4"},oe={name:"Receivers"},le=Object.assign(oe,{props:{receivers:{required:!0,type:Object}},setup(u){const c=u;var g=h(1),r=h(""),n=h(!1);const a=K(),p=i=>{r.value=r.value!=null?r.value:"",n.value=!0,a.sortValues(i),v.visit(`?page=${g.value}&q=${r.value}&column=${a.column}&type=${a.type}`)&&(n.value=!1)},x=()=>{v.visit(`?page=${g.value}&q=${r.value}&column=${a.column}&type=${a.type}`)},C=()=>{v.visit("?q=")};return $(()=>{r.value=new URLSearchParams(window.location.search).get("q");let i=new URLSearchParams(window.location.search).get("page");g.value=i??1}),(i,l)=>(f(),_(k,null,[m(t(S),{title:"Receivers"},{default:y(()=>[z]),_:1}),m(B,null,{default:y(()=>[e("div",E,[e("div",F,[D,e("div",M," Page: "+o(c.receivers.current_page)+" | total: "+o(c.receivers.total)+" | from: "+o(c.receivers.from)+", to: "+o(c.receivers.to),1)]),e("div",T,[m(L,{modelValue:t(r),"onUpdate:modelValue":l[0]||(l[0]=s=>V(r)?r.value=s:r=s),class:"mb-8",label:"Search",placeholder:"Search",title:"searchValue",onKeyup:P(x,["enter"])},null,8,["modelValue","onKeyup"]),e("button",{onClick:x,type:"button",class:"mb-8 flex items-center text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800"}," Search "),t(r)?(f(),_("button",{key:0,onClick:C,type:"button",class:"mb-8 flex items-center text-blue-700 bg-white border border-blue-700 hover:bg-gray-100 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800"}," Clear ")):R("",!0)]),e("div",Z,[e("table",A,[e("thead",G,[e("tr",null,[e("th",{class:b(["px-6 py-3",t(n)?"disabled":"clickable"]),scope:"col",onClick:l[1]||(l[1]=s=>p("first_name"))},[d(" Name "),e("span",H,o(t(a).column=="first_name"?"("+t(a).type+")":""),1)],2),e("th",{class:b(["px-6 py-3",t(n)?"disabled":"clickable"]),scope:"col",onClick:l[2]||(l[2]=s=>p("email"))},[d(" Email "),e("span",J,o(t(a).column=="email"?"("+t(a).type+")":""),1)],2),e("th",{class:b(["px-6 py-3",t(n)?"disabled":"clickable"]),scope:"col",onClick:l[3]||(l[3]=s=>p("phone"))},[d(" Phone "),e("span",Q,o(t(a).column=="phone"?"("+t(a).type+")":""),1)],2),e("th",{class:b(["px-6 py-3",t(n)?"disabled":"clickable"]),scope:"col",onClick:l[4]||(l[4]=s=>p("country"))},[d(" Country Code "),e("span",W,o(t(a).column=="country"?"("+t(a).type+")":""),1)],2),e("th",{class:b(["px-6 py-3",t(n)?"disabled":"clickable"]),scope:"col",onClick:l[5]||(l[5]=s=>p("label"))},[d(" Bank "),e("span",X,o(t(a).column=="label"?"("+t(a).type+")":""),1)],2)])]),e("tbody",null,[(f(!0),_(k,null,I(c.receivers.data,s=>(f(),_("tr",{key:s.id,class:"bg-white border-b dark:bg-gray-900 dark:border-gray-700"},[e("th",Y,[m(t(q),{href:i.route("single.receiver.page",s.id),class:"text-blue-700 hover:text-blue-900 hover:underline"},{default:y(()=>[d(o(s.first_name)+" "+o(s.last_name),1)]),_:2},1032,["href"])]),e("td",ee,o(s.email),1),e("td",te,o(s.phone),1),e("td",se,o(s.country),1),e("td",ae,o(s.bank.label),1)]))),128))])])]),m(O,{links:c.receivers.links},null,8,["links"])])]),_:1})],64))}}),ge=U(le,[["__scopeId","data-v-de0afa71"]]);export{ge as default};