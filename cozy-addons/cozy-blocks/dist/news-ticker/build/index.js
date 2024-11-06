(()=>{"use strict";var e,o={648:()=>{const e=window.wp.blocks,o=window.React,n=window.wp.i18n,t=window.wp.blockEditor,a=window.wp.components,i=window.wp.element,r=window.wp.compose;function l(e,o){return`\n    #${e} .swiper-container {\n        height: ${o.height}px;\n    }\n\n    #${e} .swiper-button-prev::after,\n    #${e} .swiper-button-next::after {\n        font-size: ${o.carouselOptions.navigation.iconSize}px;\n    }\n    #${e} .swiper-button-prev,\n    #${e} .swiper-button-next {\n        width: ${o.carouselOptions.navigation.iconBoxWidth}px;\n        height: ${o.carouselOptions.navigation.iconBoxHeight}px;\n        border-radius: ${o.carouselOptions.navigation.borderRadius}px;\n        color: ${o.carouselOptions.navigation.color};\n        background-color: ${o.carouselOptions.navigation.backgroundColor};\n        margin-top: ${o.carouselOptions.navigation.verticalGap}px;\n    }\n    #${e} .swiper-button-prev:hover,\n    #${e} .swiper-button-next:hover {\n        color: ${o.carouselOptions.navigation.colorHover};\n        background-color: ${o.carouselOptions.navigation.backgroundColorHover};\n    }\n    #${e} .swiper-button-prev {\n        right: var(--swiper-navigation-sides-offset, ${o.carouselOptions.navigation.horizontalGap}px);\n    }\n    `}const s=(0,i.memo)((()=>{const e=(0,t.useInnerBlocksProps)({className:"cozy-block-news-ticker"},{template:[["core/query",{className:"swiper-container swiper-vertical",queryId:1,query:{perPage:"6",postType:"post"},lock:{move:!1,remove:!0}},[["core/post-template",{className:"swiper-wrapper",lock:{move:!1,remove:!0}},[["core/post-title",{fontSize:"medium"}]]]]]]});return(0,o.createElement)("div",{...e})})),c=(0,i.memo)((({clientId:e,attributes:n,blockId:t})=>{const a=(0,r.useRefEffect)((e=>{const o=setInterval((()=>{if(e){const t=e.querySelectorAll(".wp-block-post");if(t.length>0){clearInterval(o),t.forEach((e=>{e.classList.add("swiper-slide")}));const a=e.querySelector(".swiper-container"),i=e.querySelector(".swiper-button-prev"),r=e.querySelector(".swiper-button-next"),l={direction:"vertical",loop:n.carouselOptions.sliderOptions.loop,speed:n.carouselOptions.sliderOptions.speed,slidesPerView:n.carouselOptions.sliderOptions.slidesPerView,spaceBetween:n.carouselOptions.sliderOptions.spaceBetween,navigation:{nextEl:r,prevEl:i}};new Swiper(a,l)}}return()=>{clearInterval(o)}}),1e3);return()=>{}}));return(0,o.createElement)(o.Fragment,null,(0,o.createElement)("style",{dangerouslySetInnerHTML:{__html:l(t,n)}}),(0,o.createElement)("div",{className:"cozy-block-news-ticker-wrapper "+(n.hoverShow?"hover-show":""),id:t,ref:a},(0,o.createElement)(s,null),n.carouselOptions.navigation.enabled&&(0,o.createElement)(o.Fragment,null,(0,o.createElement)("div",{className:"swiper-button-prev cozy-block-button-prev"}),(0,o.createElement)("div",{className:"swiper-button-next cozy-block-button-next"}))))})),p=JSON.parse('{"UU":"cozy-block/news-ticker","h_":"Stay informed with our \'News Ticker\' block, delivering real-time headlines in a scrolling format for an engaging and dynamic user experience."}'),u=(0,o.createElement)("svg",{width:"27",height:"21",viewBox:"0 0 27 21",fill:"none",xmlns:"http://www.w3.org/2000/svg"},(0,o.createElement)("rect",{fill:"none",x:"1",y:"1",width:"25",height:"19",stroke:"#0C50FF","stroke-width":"2"}),(0,o.createElement)("path",{fill:"none",d:"M4 16H9",stroke:"#0C50FF","stroke-width":"2"}),(0,o.createElement)("path",{fill:"none",d:"M10 16H17",stroke:"#0C50FF","stroke-opacity":"0.5"}),(0,o.createElement)("path",{fill:"none",d:"M18 16H23",stroke:"#0C50FF","stroke-opacity":"0.5"}),(0,o.createElement)("rect",{x:"4",y:"4",width:"10",height:"10",rx:"5",fill:"#0C50FF"}),(0,o.createElement)("path",{d:"M10.7001 7.875H9.25761L9.7901 6.35391C9.8401 6.17578 9.69635 6 9.5001 6H7.70012C7.55013 6 7.42263 6.1043 7.40263 6.24375L7.00263 9.05625C6.97888 9.225 7.11888 9.375 7.30013 9.375H8.78386L8.20762 11.6543C8.16262 11.8324 8.30762 12 8.49887 12C8.60386 12 8.70386 11.9484 8.75886 11.8594L10.9588 8.29688C11.0751 8.11055 10.9313 7.875 10.7001 7.875Z",fill:"white"}));(0,e.registerBlockType)(p.UU,{title:(0,n.__)("News Ticker","cozy-addons"),description:(0,n.__)(p.h_,"cozy-addons"),icon:{src:u},example:{attributes:{cover:cozyBlockAssets.imageDir+"/preview_news_ticker.jpg"},viewportWidth:1260},edit:function(e){const{attributes:i,setAttributes:r,clientId:l}=e;if(i.cover)return(0,o.createElement)("img",{src:i.cover});i.blockClientId=l;const s=(0,t.useBlockProps)({className:"cozy-block-wrapper"}),p=`cozyBlock_${l.replace(/-/gi,"_")}`;return(0,o.createElement)(o.Fragment,null,(0,o.createElement)("div",{...s},(0,o.createElement)(c,{clientId:l,attributes:i,blockId:p})),(0,o.createElement)(t.InspectorControls,{key:"setting",group:"settings"},(0,o.createElement)(a.PanelBody,{title:(0,n.__)("General","cozy-addons")},(0,o.createElement)(a.RangeControl,{label:(0,n.__)("Height","cozy-addons"),min:20,max:1500,step:5,value:i.height,onChange:e=>r({...i,height:Math.abs(e)})})),(0,o.createElement)(a.PanelBody,{title:(0,n.__)("Ticker Options","cozy-addons"),initialOpen:!1},(0,o.createElement)(a.TextControl,{label:(0,n.__)("Slides per view","cozy-addons"),value:i.carouselOptions.sliderOptions.slidesPerView,onChange:e=>r({...i,carouselOptions:{...i.carouselOptions,sliderOptions:{...i.carouselOptions.sliderOptions,slidesPerView:e}}}),type:"number",min:.1,step:.1}),(0,o.createElement)(a.RangeControl,{label:(0,n.__)("Gap","cozy-addons"),value:i.carouselOptions.sliderOptions.spaceBetween,onChange:e=>r({...i,carouselOptions:{...i.carouselOptions,sliderOptions:{...i.carouselOptions.sliderOptions,spaceBetween:e}}}),min:0,step:1,max:100}),(0,o.createElement)(a.ToggleControl,{label:(0,n.__)("Loop","cozy-addons"),checked:i.carouselOptions.sliderOptions.loop,onChange:e=>r({...i,carouselOptions:{...i.carouselOptions,sliderOptions:{...i.carouselOptions.sliderOptions,loop:e}}})}),(0,o.createElement)(a.ToggleControl,{label:(0,n.__)("Autoplay","cozy-addons"),checked:i.carouselOptions.sliderOptions.autoplay,onChange:e=>r({carouselOptions:{...i.carouselOptions,sliderOptions:{...i.carouselOptions.sliderOptions,autoplay:e}}})}),(0,o.createElement)(a.TextControl,{label:(0,n.__)("Speed (ms)","cozy-addons"),type:"number",value:i.carouselOptions.sliderOptions.speed,min:500,step:100,onChange:e=>r({...i,carouselOptions:{...i.carouselOptions,sliderOptions:{...i.carouselOptions.sliderOptions,speed:e}}}),help:(0,n.__)("*Greater the value, greater the delay.","cozy-addons")}),(0,o.createElement)(a.ToggleControl,{label:(0,n.__)("Enable Navigation","cozy-addons"),checked:i.carouselOptions.navigation.enabled,onChange:e=>r({...i,carouselOptions:{...i.carouselOptions,navigation:{...i.carouselOptions.navigation,enabled:e}}})}),i.carouselOptions.navigation.enabled&&(0,o.createElement)(o.Fragment,null,(0,o.createElement)(a.ToggleControl,{label:(0,n.__)("Display on Hover","cozy-addons"),checked:i.hoverShow,onChange:e=>r({hoverShow:e}),help:(0,n.__)("*Show navigation only after hovering the block.")})))),(0,o.createElement)(t.InspectorControls,{key:"style",group:"styles"},i.carouselOptions.navigation.enabled&&(0,o.createElement)(a.PanelBody,{title:(0,n.__)("Navigation Style","cozy-addons"),initialOpen:!1},(0,o.createElement)(a.RangeControl,{label:(0,n.__)("Icon Size","cozy-addons"),value:i.carouselOptions.navigation.iconSize,min:1,max:50,onChange:e=>r({...i,carouselOptions:{...i.carouselOptions,navigation:{...i.carouselOptions.navigation,iconSize:e}}})}),(0,o.createElement)(a.RangeControl,{label:(0,n.__)("Icon Box Width","cozy-addons"),value:i.carouselOptions.navigation.iconBoxWidth,min:1,max:50,onChange:e=>r({...i,carouselOptions:{...i.carouselOptions,navigation:{...i.carouselOptions.navigation,iconBoxWidth:e}}})}),(0,o.createElement)(a.RangeControl,{label:(0,n.__)("Icon Box Height","cozy-addons"),value:i.carouselOptions.navigation.iconBoxHeight,min:1,max:50,onChange:e=>r({...i,carouselOptions:{...i.carouselOptions,navigation:{...i.carouselOptions.navigation,iconBoxHeight:e}}})}),(0,o.createElement)(a.RangeControl,{label:(0,n.__)("Border Radius","cozy-addons"),value:i.carouselOptions.navigation.borderRadius,min:1,max:50,onChange:e=>r({...i,carouselOptions:{...i.carouselOptions,navigation:{...i.carouselOptions.navigation,borderRadius:e}}})}),(0,o.createElement)(a.RangeControl,{label:(0,n.__)("Vertical Gap","cozy-addons"),min:-300,max:300,step:1,value:i.carouselOptions.navigation.verticalGap,onChange:e=>r({...i,carouselOptions:{...i.carouselOptions,navigation:{...i.carouselOptions.navigation,verticalGap:e}}})}),(0,o.createElement)(a.RangeControl,{label:(0,n.__)("Horizontal Gap","cozy-addons"),min:0,max:200,step:1,value:i.carouselOptions.navigation.horizontalGap,onChange:e=>r({...i,carouselOptions:{...i.carouselOptions,navigation:{...i.carouselOptions.navigation,horizontalGap:Math.abs(e)}}})}),(0,o.createElement)(t.PanelColorSettings,{className:"cozy-color-control",enableAlpha:!0,title:(0,n.__)("Background Color","cozy-addons"),colorSettings:[{value:i.carouselOptions.navigation.backgroundColor,onChange:e=>r({...i,carouselOptions:{...i.carouselOptions,navigation:{...i.carouselOptions.navigation,backgroundColor:e}}}),label:(0,n.__)("Normal","cozy-addons")},{value:i.carouselOptions.navigation.backgroundColorHover,onChange:e=>r({...i,carouselOptions:{...i.carouselOptions,navigation:{...i.carouselOptions.navigation,backgroundColorHover:e}}}),label:(0,n.__)("Hover","cozy-addons")}]}),(0,o.createElement)(t.PanelColorSettings,{className:"cozy-color-control",enableAlpha:!0,title:(0,n.__)("Color","cozy-addons"),colorSettings:[{value:i.carouselOptions.navigation.color,onChange:e=>r({...i,carouselOptions:{...i.carouselOptions,navigation:{...i.carouselOptions.navigation,color:e}}}),label:(0,n.__)("Normal","cozy-addons")},{value:i.carouselOptions.navigation.colorHover,onChange:e=>r({...i,carouselOptions:{...i.carouselOptions,navigation:{...i.carouselOptions.navigation,colorHover:e}}}),label:(0,n.__)("Hover","cozy-addons")}]}))))},save:function({attributes:e}){const{blockClientId:n}=e,a=`cozyBlock_${(i=n,i.replace(/[;=()\s]/g,"")).replace(/-/gi,"_")}`;var i;return(0,o.createElement)(o.Fragment,null,(0,o.createElement)("div",{className:"cozy-block-news-ticker-wrapper "+(e.hoverShow?"hover-show":""),id:a},(0,o.createElement)(t.InnerBlocks.Content,null),e.carouselOptions.navigation.enabled&&(0,o.createElement)(o.Fragment,null,(0,o.createElement)("div",{className:"swiper-button-prev cozy-block-button-prev"}),(0,o.createElement)("div",{className:"swiper-button-next cozy-block-button-next"}))))}})}},n={};function t(e){var a=n[e];if(void 0!==a)return a.exports;var i=n[e]={exports:{}};return o[e](i,i.exports,t),i.exports}t.m=o,e=[],t.O=(o,n,a,i)=>{if(!n){var r=1/0;for(p=0;p<e.length;p++){for(var[n,a,i]=e[p],l=!0,s=0;s<n.length;s++)(!1&i||r>=i)&&Object.keys(t.O).every((e=>t.O[e](n[s])))?n.splice(s--,1):(l=!1,i<r&&(r=i));if(l){e.splice(p--,1);var c=a();void 0!==c&&(o=c)}}return o}i=i||0;for(var p=e.length;p>0&&e[p-1][2]>i;p--)e[p]=e[p-1];e[p]=[n,a,i]},t.o=(e,o)=>Object.prototype.hasOwnProperty.call(e,o),(()=>{var e={57:0,350:0};t.O.j=o=>0===e[o];var o=(o,n)=>{var a,i,[r,l,s]=n,c=0;if(r.some((o=>0!==e[o]))){for(a in l)t.o(l,a)&&(t.m[a]=l[a]);if(s)var p=s(t)}for(o&&o(n);c<r.length;c++)i=r[c],t.o(e,i)&&e[i]&&e[i][0](),e[i]=0;return t.O(p)},n=globalThis.webpackChunknews_ticker=globalThis.webpackChunknews_ticker||[];n.forEach(o.bind(null,0)),n.push=o.bind(null,n.push.bind(n))})();var a=t.O(void 0,[350],(()=>t(648)));a=t.O(a)})();