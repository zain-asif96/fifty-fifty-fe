import{_ as i}from"./FiftyText-b13f5419.js";import{r as c,d as f,o as l,c as s,b as r,a as b,w as g,g as m,t as o,f as y,F as v,h as x,n as h}from"./app-db97278d.js";const p={class:"w-full flex flex-col justify-start relative"},w=["for"],S={key:0,class:"text-red-600"},V=["disabled","value"],_={class:"bg-gray-200",disabled:"",value:""},k=["value"],A={class:"text-red-600 text-base"},N={name:"NewSelectInput"},C=Object.assign(N,{props:{modelValue:{required:!0},label:{default:"",type:String},placeholder:{default:"",type:String},type:{default:"text"},required:{type:Boolean,default:!1},disabled:{type:Boolean,default:!1},errors:{type:Object,default:{}},title:{type:String,required:!0},labelAccessor:{type:String,default:"label"},valueAccessor:{type:String,default:"value"},options:{type:Array,required:!0}},emits:["update:modelValue"],setup(e,{expose:d}){const a=c(null);return f(()=>{a.value.hasAttribute("autofocus")&&a.value.focus()}),d({focus:()=>a.value.focus()}),(n,u)=>(l(),s("div",p,[r("label",{for:e.title,class:"w-fit inline-block mb-2"},[b(i,null,{default:g(()=>[m(o(e.label??"")+" ",1),e.required?(l(),s("span",S,"*")):y("",!0)]),_:1})],8,w),r("select",{id:"exampleFormControlInput1",ref_key:"input",ref:a,class:h([{"border-red-300":e.errors.length>0,"bg-gray-300":e.disabled},"form-control block w-full px-3 py-1.5 text-lg font-normal text-gray-700 bg-clip-padding border border-solid border-gray-300 rounded transition ease-linear m-0 focus:text-gray-700 focus:bg-white focus:border-indigo-300 focus:outline-none"]),disabled:e.disabled,value:e.modelValue,onChange:u[0]||(u[0]=t=>n.$emit("update:modelValue",t.target.value))},[r("option",_,"--"+o(e.placeholder)+"--",1),(l(!0),s(v,null,x(e.options,t=>(l(),s("option",{key:t[e.valueAccessor],value:t[e.valueAccessor]},o(t[e.labelAccessor]),9,k))),128))],42,V),r("div",A,o(e.errors[0]),1)]))}});export{C as _};
