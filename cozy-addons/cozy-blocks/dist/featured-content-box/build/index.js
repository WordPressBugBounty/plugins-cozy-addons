(()=>{"use strict";var e,o={838:()=>{const e=window.wp.blocks,o=window.wp.i18n,a=window.wp.blockEditor,n=window.wp.components,t=window.React,i=window.wp.primitives,l=(0,t.createElement)(i.SVG,{xmlns:"http://www.w3.org/2000/svg",viewBox:"-2 -2 24 24"},(0,t.createElement)(i.Path,{d:"M10 1c-5 0-9 4-9 9s4 9 9 9 9-4 9-9-4-9-9-9zm0 16c-3.9 0-7-3.1-7-7s3.1-7 7-7 7 3.1 7 7-3.1 7-7 7zm1-11H9v3H6v2h3v3h2v-3h3V9h-3V6zM10 1c-5 0-9 4-9 9s4 9 9 9 9-4 9-9-4-9-9-9zm0 16c-3.9 0-7-3.1-7-7s3.1-7 7-7 7 3.1 7 7-3.1 7-7 7zm1-11H9v3H6v2h3v3h2v-3h3V9h-3V6z"})),r=(0,t.createElement)(i.SVG,{xmlns:"http://www.w3.org/2000/svg",viewBox:"0 0 24 24"},(0,t.createElement)(i.Path,{d:"M9 9v6h11V9H9zM4 20h1.5V4H4v16z"})),s=(0,t.createElement)(i.SVG,{xmlns:"http://www.w3.org/2000/svg",viewBox:"0 0 24 24"},(0,t.createElement)(i.Path,{d:"M12.5 15v5H11v-5H4V9h7V4h1.5v5h7v6h-7Z"})),c=(0,t.createElement)(i.SVG,{xmlns:"http://www.w3.org/2000/svg",viewBox:"0 0 24 24"},(0,t.createElement)(i.Path,{d:"M4 15h11V9H4v6zM18.5 4v16H20V4h-1.5z"})),d=window.wp.data,p=window.wp.compose,g=window.wp.element;function y(e,o){function a(e,o){return o&&Object.keys(o).length<4?1===Object.keys(o).length?`\n        ${e}: ${o};\n      `:`\n        ${e}: ${o.width} ${o.style} ${o.color};\n      `:o&&4===Object.keys(o).length?"border"===e?`\n          border-top: ${o?.top?.width} ${o?.top?.style} ${o?.top?.color};\n          border-right: ${o?.right?.width} ${o?.right?.style} ${o?.right?.color};\n          border-bottom: ${o?.bottom?.width} ${o?.bottom?.style} ${o?.bottom?.color};\n          border-left: ${o?.left?.width} ${o?.left?.style} ${o?.left?.color};\n        `:`\n      ${e}: ${o.top} ${o.right} ${o.bottom} ${o.left};\n    `:""}return`\n        #${e} {\n            margin: ${o.margin.top}px ${o.margin.right}px ${o.margin.bottom}px ${o.margin.left}px;\n        }\n\n        #${e}.display-grid .cozy-grid-wrapper {\n            row-gap: ${o.gridOptions.gap}px;\n            column-gap: ${o.gridOptions.gap}px;\n        }\n        #${e}.display-grid:not(.has-masonry) .cozy-grid-wrapper {\n            grid-template-columns: repeat(${o.gridOptions.columnCount}, 1fr);\n        }\n        #${e}.display-grid.has-masonry .cozy-grid-wrapper {\n            column-count: ${o.gridOptions.columnCount};\n        }\n        #${e}.display-grid.has-masonry .cozy-grid-wrapper .cozy-block-grid:not(:first-child) {\n            margin-top: ${o.gridOptions.gap}px;\n        }\n\n        #${e}.layout-stacked .cozy-stacked-image {\n            bottom: ${o.stackedImage.verticalPosition}px;\n        }\n\n        #${e}.layout-gallery .cozy-featured-content-box__layout-gallery-wrapper:hover .wp-block-cover__background {\n            background-color: ${o.galleryOptions.overlayColorHover} !important;\n            opacity: ${o.galleryOptions.overlayOpacity} !important;\n        }\n\n        #${e} .swiper-button-prev::after,\n        #${e} .swiper-button-next::after {\n            font-size: ${o.navigation.iconSize}px;\n        }\n        #${e} .swiper-button-prev,\n        #${e} .swiper-button-next {\n            width: ${o.navigation.iconBoxWidth}px;\n            height: ${o.navigation.iconBoxHeight}px;\n            ${a("border",o.navigation?.border)}\n            border-radius: ${o.navigation.borderRadius}px;\n            color: ${o.navigation.color};\n            background-color: ${o.navigation.backgroundColor};\n        }\n        #${e} .swiper-button-prev:hover,\n        #${e} .swiper-button-next:hover {\n            color: ${o.navigation.colorHover};\n            background-color: ${o.navigation.backgroundColorHover};\n            border-color: ${o.navigation?.borderHover};\n        }\n\n        #${e} .swiper-pagination {\n            bottom: ${o.pagination.verticalPosition}px;\n            text-align: ${o.pagination?.align?o.pagination?.align:"center"};\n            ${"left"===o.pagination?.align?"padding-left:"+o.pagination?.left+";":""}\n            ${"right"===o.pagination?.align?"padding-right:"+o.pagination?.right+";":""}\n        }\n        #${e} .swiper-pagination .swiper-pagination-bullet {\n            width: ${o.pagination.width}px;\n            height: ${o.pagination.height}px;\n            border-radius: ${o.pagination.borderRadius}px;\n            background-color: ${o.pagination.color};\n        }\n        #${e}.swiper-horizontal > .swiper-pagination-bullets .swiper-pagination-bullet {\n            margin: 0 var(--swiper-pagination-bullet-horizontal-gap, ${o.pagination?.gap}px);\n        }\n        #${e} .swiper-pagination .swiper-pagination-bullet-active {\n            width: ${o.pagination.activeWidth}px;\n            height: ${o.pagination?.activeHeight}px;\n            ${a("outline",o.pagination?.activeBorder)}\n            outline-offset: ${o.pagination?.activeOffset}px;\n            border-radius: ${o.pagination.activeBorderRadius}px;\n            background-color: ${o.pagination.activeColor};\n        }\n        #${e} .swiper-pagination .swiper-pagination-bullet:hover {\n            background-color: ${o.pagination.colorHover};\n        }\n        #${e} .swiper-pagination .swiper-pagination-bullet-active:hover {\n            background-color: ${o.pagination.activeColorHover};\n            outline-color: ${o.pagination?.activeBorderHover};\n        }\n    `}const u=window.ReactJSXRuntime,m=()=>(0,u.jsx)(u.Fragment,{children:(0,u.jsxs)("div",{style:{display:"flex",flexDirection:"column",justifyContent:"center",alignItems:"center",padding:"16px",marginBottom:"10px"},children:[(0,u.jsx)("p",{children:(0,u.jsxs)("svg",{width:"41",height:"48",viewBox:"0 0 41 48",fill:"none",xmlns:"http://www.w3.org/2000/svg",children:[(0,u.jsx)("path",{d:"M0 34.7721L6.88004 38.677V15.8055L20.4542 7.80977L23.9872 9.4833L30.4953 5.57841L20.4542 -7.62939e-06L0 11.9006V34.7721Z",fill:"#38DAC7"}),(0,u.jsx)("path",{d:"M32.9284 6.87939L34.2126 7.61318L12.3825 19.904L12.1991 40.45L20.6376 45.8616L41.0001 33.6625V35.4969L20.6376 47.6043L10.8232 41.2755V18.9868L32.9284 6.87939Z",fill:"#5566CA"}),(0,u.jsx)("path",{d:"M37.6063 9.53936L36.2305 8.71385L14.217 21.3716V38.9824L20.5459 43.5685L41.0001 31.3694V29.5349L20.5459 41.8258L15.5928 38.2486V22.1054L37.6063 9.53936Z",fill:"#5566CA"}),(0,u.jsx)("path",{d:"M41.0001 11.3738L39.5325 10.5483L17.3356 23.2061V37.2397L20.5459 39.6244L41.0001 27.4253V25.6826L20.5459 37.79L18.9866 36.5976V24.1233L41.0001 11.3738Z",fill:"#5566CA"})]})}),(0,u.jsx)("h2",{style:{fontSize:"18px",fontFamily:"Inter",marginTop:"-5px",marginBottom:"15px"},children:(0,o.__)("Access Without Limits!","cozy-addons")}),(0,u.jsx)("p",{style:{textAlign:"center",lineHeight:"20px"},children:(0,o.__)("Access more blocks and advanced features for effortless design. Upgrade today for a richer web-building experience!","cozy-addons")}),(0,u.jsx)("a",{href:"https://cozythemes.com/pricing-and-plans/",target:"_blank",children:(0,u.jsx)("button",{className:"cozy-block-premium-button",style:{backgroundColor:"#5566ca",borderRadius:"20px",padding:"10px",border:"none",color:"#fff",fontFamily:"Inter",fontSize:"10px",fontWeight:"500",cursor:"pointer"},children:(0,u.jsxs)("div",{style:{display:"flex",gap:"5px",margin:"0"},children:[(0,u.jsx)("div",{children:(0,u.jsx)("svg",{width:"10",height:"10",viewBox:"0 0 10 10",fill:"none",xmlns:"http://www.w3.org/2000/svg",children:(0,u.jsx)("path",{d:"M9.29768 0.0630875L0.24397 5.2847C-0.109583 5.48778 -0.0646564 5.97987 0.286944 6.12828L2.36334 6.99919L7.97527 2.05487C8.0827 1.95919 8.23506 2.10565 8.14325 2.21695L3.43767 7.94822V9.52017C3.43767 9.98102 3.99437 10.1626 4.26784 9.8287L5.50821 8.31924L7.94206 9.33857C8.21943 9.45573 8.53588 9.28194 8.58666 8.98317L9.99306 0.547365C10.0595 0.152913 9.6356 -0.132186 9.29768 0.0630875Z",fill:"white"})})}),(0,u.jsx)("div",{children:(0,o.__)("Upgrade to Pro","cozy-addons")})]})})})]})}),h=[["cozy-block/grid",{},[["core/group",{lock:{move:!0,remove:!0},layout:{type:"constrained"},className:"cozy-featured-content-box__container"},[["core/group",{lock:{move:!1,remove:!0},style:{spacing:{margin:{top:"0",bottom:"26px"}}},className:"cozy-layout-wrapper",metadata:{name:(0,o.__)("Featured Image","cozy-addons")}},[["core/image",{lock:{move:!0,remove:!0},className:"cozy-featured-content-box__featured-image",align:"center",url:cozyBlockAssets.imageDir+"image_placeholder.jpg"},[]],["core/image",{lock:{move:!0,remove:!0},className:"cozy-stacked-image",url:cozyBlockAssets.imageDir+"image_placeholder_dark.jpg",width:"67px",style:{border:{radius:"50px"}}},[]]]],["core/heading",{placeholder:(0,o.__)("Featured Title","cozy-addons"),textAlign:"center",level:4}],["core/paragraph",{placeholder:(0,o.__)("Lorem Ipsum is simply dummy text of the printing and typesetting industry.","cozy-addons"),align:"center"}],["core/buttons",{layout:{type:"flex",justifyContent:"center"},style:{spacing:{margin:{top:"16px"}}}},[["core/button",{placeholder:(0,o.__)("Read More","cozy-addons")},[]]]]]]]],["cozy-block/grid",{},[["core/group",{lock:{move:!0,remove:!0},layout:{type:"constrained"},className:"cozy-featured-content-box__container"},[["core/group",{lock:{move:!1,remove:!0},style:{spacing:{margin:{top:"0",bottom:"26px"}}},className:"cozy-layout-wrapper",metadata:{name:(0,o.__)("Featured Image","cozy-addons")}},[["core/image",{lock:{move:!0,remove:!0},className:"cozy-featured-content-box__featured-image",align:"center",url:cozyBlockAssets.imageDir+"image_placeholder.jpg"},[]],["core/image",{lock:{move:!0,remove:!0},className:"cozy-stacked-image",url:cozyBlockAssets.imageDir+"image_placeholder_dark.jpg",width:"67px",style:{border:{radius:"50px"}}},[]]]],["core/heading",{placeholder:(0,o.__)("Featured Title","cozy-addons"),textAlign:"center",level:4}],["core/paragraph",{placeholder:(0,o.__)("Lorem Ipsum is simply dummy text of the printing and typesetting industry.","cozy-addons"),align:"center"}],["core/buttons",{layout:{type:"flex",justifyContent:"center"},style:{spacing:{margin:{top:"16px"}}}},[["core/button",{placeholder:(0,o.__)("Read More","cozy-addons")},[]]]]]]]],["cozy-block/grid",{},[["core/group",{lock:{move:!0,remove:!0},layout:{type:"constrained"},className:"cozy-featured-content-box__container"},[["core/group",{lock:{move:!1,remove:!0},style:{spacing:{margin:{top:"0",bottom:"26px"}}},className:"cozy-layout-wrapper",metadata:{name:(0,o.__)("Featured Image","cozy-addons")}},[["core/image",{lock:{move:!0,remove:!0},className:"cozy-featured-content-box__featured-image",align:"center",url:cozyBlockAssets.imageDir+"image_placeholder.jpg"},[]],["core/image",{lock:{move:!0,remove:!0},className:"cozy-stacked-image",url:cozyBlockAssets.imageDir+"image_placeholder_dark.jpg",width:"67px",style:{border:{radius:"50px"}}},[]]]],["core/heading",{placeholder:(0,o.__)("Featured Title","cozy-addons"),textAlign:"center",level:4}],["core/paragraph",{placeholder:(0,o.__)("Lorem Ipsum is simply dummy text of the printing and typesetting industry.","cozy-addons"),align:"center"}],["core/buttons",{layout:{type:"flex",justifyContent:"center"},style:{spacing:{margin:{top:"16px"}}}},[["core/button",{placeholder:(0,o.__)("Read More","cozy-addons")},[]]]]]]]]],v=[["core/group",{layout:{type:"constrained"},className:"cozy-featured-content-box__container",lock:{move:!0,remove:!0}},[["core/group",{lock:{move:!1,remove:!0},style:{spacing:{margin:{top:"0",bottom:"26px"}}},className:"cozy-layout-wrapper",metadata:{name:(0,o.__)("Featured Image","cozy-addons")}},[["core/image",{lock:{move:!0,remove:!0},className:"cozy-featured-content-box__featured-image",align:"center",url:cozyBlockAssets.imageDir+"image_placeholder.jpg"},[]],["core/image",{lock:{move:!0,remove:!0},className:"cozy-stacked-image",url:cozyBlockAssets.imageDir+"image_placeholder_dark.jpg",width:"67px",style:{border:{radius:"50px"}}},[]]]],["core/heading",{placeholder:(0,o.__)("Featured Title","cozy-addons"),textAlign:"center",level:4}],["core/paragraph",{placeholder:(0,o.__)("Lorem Ipsum is simply dummy text of the printing and typesetting industry.","cozy-addons"),align:"center"}],["core/buttons",{layout:{type:"flex",justifyContent:"center"},style:{spacing:{margin:{top:"16px"}}}},[["core/button",{placeholder:(0,o.__)("Read More","cozy-addons")},[]]]]]]],x=[["core/group",{lock:{move:!0,remove:!0},layout:{type:"constrained"},className:"cozy-featured-content-box__container"},[["core/group",{lock:{move:!1,remove:!0},style:{spacing:{margin:{top:"0",bottom:"26px"}}},className:"cozy-layout-wrapper",metadata:{name:(0,o.__)("Featured Image","cozy-addons")}},[["core/image",{lock:{move:!0,remove:!0},align:"center",className:"cozy-featured-content-box__featured-image",url:cozyBlockAssets.imageDir+"image_placeholder.jpg"},[]],["core/image",{lock:{move:!0,remove:!0},className:"cozy-stacked-image",url:cozyBlockAssets.imageDir+"image_placeholder_dark.jpg",width:"67px",style:{border:{radius:"50px"}}},[]]]],["core/heading",{placeholder:(0,o.__)("Featured Title","cozy-addons"),textAlign:"center",level:4}],["core/paragraph",{placeholder:(0,o.__)("Lorem Ipsum is simply dummy text of the printing and typesetting industry.","cozy-addons"),align:"center"}],["core/buttons",{layout:{type:"flex",justifyContent:"center"},style:{spacing:{margin:{top:"16px"}}}},[["core/button",{placeholder:(0,o.__)("Read More","cozy-addons")},[]]]]]]];function b(e){if(!Array.isArray(e))return null;for(let o of e){if("core/image"===o.name&&o.attributes&&"cozy-featured-content-box__featured-image"===o.attributes.className&&o.attributes.url)return o.attributes.url;if(o.innerBlocks&&Array.isArray(o.innerBlocks)&&o.innerBlocks.length>0){const e=b(o.innerBlocks);if(e)return e}}return null}function _(o){if("core/group"===o[0].name&&o[0].attributes.className.includes("cozy-featured-content-box__container")){const a=b(o[0].innerBlocks);(0,d.dispatch)("core/block-editor").replaceBlock(o[0].clientId,(0,e.createBlock)("core/cover",{className:"cozy-featured-content-box__layout-gallery",url:a||cozyBlockAssets.imageDir+"image_placeholder.jpg",dimRatio:40,isDark:!1},(0,e.createBlocksFromInnerBlocksTemplate)(o)))}}function z(e,o){if(Array.isArray(e))for(let a of e){if("core/image"===a.name&&a.attributes&&"cozy-featured-content-box__featured-image"===a.attributes.className&&a.attributes.url)return void(a.attributes.url=o.url);a.innerBlocks&&Array.isArray(a.innerBlocks)&&a.innerBlocks.length>0&&z(a.innerBlocks,o)}}function k(o){"core/cover"===o[0].name&&o[0].attributes.className.includes("cozy-featured-content-box__layout-gallery")&&(z(o[0].innerBlocks,{url:o[0].attributes.url}),(0,d.dispatch)("core/block-editor").replaceBlock(o[0].clientId,(0,e.createBlocksFromInnerBlocksTemplate)(o[0].innerBlocks)))}const w=(0,g.memo)((({display:e,layout:o})=>{const n=(0,a.useInnerBlocksProps)({className:`cozy-${e}-wrapper ${"carousel"===e?"swiper-wrapper":""}`},{allowedBlocks:["cozy-block/grid","cozy-block/carousel"],template:h,renderAppender:!1,orientation:"horizontal"});return(0,u.jsx)("div",{...n})})),C=(0,g.memo)((({clientId:t,display:i,layout:r})=>{const{insertBlock:s,selectBlock:c}=(0,d.useDispatch)(a.store),p=(0,d.useSelect)((e=>e(a.store).getBlock(t).innerBlocks));return(0,u.jsx)(n.ToolbarGroup,{children:(0,u.jsx)(n.ToolbarButton,{icon:l,onClick:()=>{let o=[];o="grid"===i?(0,e.createBlock)("cozy-block/grid",{},(0,e.createBlocksFromInnerBlocksTemplate)(v)):(0,e.createBlock)("cozy-block/carousel",{},(0,e.createBlocksFromInnerBlocksTemplate)(x)),s(o,p.length,t,!1),c(o.clientId)},children:(0,o.__)("Add Item","cozy-addons")})})})),j=(0,g.memo)((({blockId:e,attributes:o,clientId:n})=>{const t=(0,p.useRefEffect)((e=>{let t={};const i=e.querySelector(".swiper-button-prev"),l=e.querySelector(".swiper-button-next"),r=e.querySelector(".swiper-pagination"),s={init:!0,loop:o.sliderOptions.loop,speed:o.sliderOptions.speed,centeredSlides:o.sliderOptions.centeredSlides,slidesPerView:o.sliderOptions.slidesPerView,spaceBetween:o.sliderOptions.spaceBetween,navigation:{nextEl:l,prevEl:i},pagination:{clickable:!0,el:r},breakpoints:{400:{slidesPerView:1},767:{slidesPerView:o.sliderOptions.slidesPerView<=2?o.sliderOptions.slidesPerView:2},1024:{slidesPerView:o.sliderOptions.slidesPerView<=3?o.sliderOptions.slidesPerView:3},1180:{slidesPerView:o.sliderOptions.slidesPerView}},allowTouchMove:!o.navigation.enabled};"carousel"===o.display&&(t=new Swiper(e,s));let c=(0,d.select)(a.store).getBlockOrder(n);const p=(0,d.subscribe)((()=>{const i=(0,d.select)(a.store).getBlockOrder(n);if("carousel"===o.display&&i.toString()!==c.toString()){const o=(0,d.select)(a.store).getSelectedBlock(),n=i.length>c.length,l=i.length<c.length,r=i.length===c.length,p=t.activeIndex;c=i,t.destroy(),window.requestAnimationFrame((()=>{t=new Swiper(e,s);let a=p;n?a=c.length:l?a=p-1:r&&(a=c.findIndex((e=>e===o.clientId))),a<0&&(a=0),t.slideTo(a,0)}))}})),g=(0,d.subscribe)((()=>{const e=(0,d.select)(a.store).getSelectedBlock(),n=e?.clientId;if("carousel"===o.display&&null!=n){const e=c.findIndex((e=>e===n));window.requestAnimationFrame((()=>{-1!==e&&t.slideTo(e)}))}}));return()=>{"carousel"===o.display&&Object.keys(t).length>0&&(t.destroy(),g(),p())}}),[o]);return(0,u.jsxs)(u.Fragment,{children:[(0,u.jsx)("style",{dangerouslySetInnerHTML:{__html:y(e,o)}}),(0,u.jsx)(a.BlockControls,{children:(0,u.jsx)(C,{clientId:n,display:o.display,layout:o.layout})}),(0,u.jsxs)("div",{className:`cozy-block-featured-content-box display-${o.display} layout-${o.layout} ${"grid"===o.display&&o.gridOptions.enableMasonry?"has-masonry":""}  ${"carousel"===o.display?"cozy-featured-content-box__swiper-container":""} ${o.hoverShow?"hover-show":""}`,id:e,ref:t,children:[(0,u.jsx)(w,{display:o.display,layout:o.layout}),"carousel"===o.display&&(0,u.jsxs)(u.Fragment,{children:[o.navigation.enabled&&(0,u.jsxs)(u.Fragment,{children:[(0,u.jsx)("div",{className:"swiper-button-prev cozy-block-button-prev"}),(0,u.jsx)("div",{className:"swiper-button-next cozy-block-button-next"})]}),o.pagination.enabled&&(0,u.jsx)("div",{className:"swiper-pagination cozy-pagination"})]})]})]})})),f=JSON.parse('{"UU":"cozy-block/featured-content-box","DD":"Featured Content Box","h_":"Presenting the \'Featured Content Box\' block – your ultimate tool for showcasing standout content! Customize your display for a visually stunning presentation that captivates your audience."}'),B=(0,u.jsx)(u.Fragment,{children:(0,u.jsxs)("svg",{width:"27",height:"22",viewBox:"0 0 27 22",fill:"none",xmlns:"http://www.w3.org/2000/svg",children:[(0,u.jsx)("rect",{fill:"none",x:"1",y:"1",width:"25",height:"20",stroke:"#0C50FF",strokeWidth:"2"}),(0,u.jsx)("path",{d:"M5 4H22V12H5V4Z",fill:"#0C50FF"}),(0,u.jsx)("path",{d:"M10 16.5H17V18.5H10V16.5Z",fill:"#0C50FF"}),(0,u.jsx)("path",{d:"M6 15H20",stroke:"#0C50FF",strokeOpacity:"0.5"}),(0,u.jsx)("path",{d:"M8 13.5L18 13.5",stroke:"#0C50FF",strokeOpacity:"0.5"})]})});(0,e.registerBlockType)(f.UU,{title:(0,o.__)(f.DD,"cozy-addons"),description:(0,o.__)(f.h_,"cozy-addons"),icon:{src:B},edit:function({attributes:t,setAttributes:i,clientId:l}){if(t.cover)return(0,u.jsx)("img",{src:t.cover});t.blockClientId=l;const p=(0,a.useBlockProps)({className:"cozy-block-wrapper"}),y=`cozyBlock_${l.replace(/-/gi,"_")}`,[h,v]=(0,g.useState)(!0),x=(e,o)=>{let a={...t.margin};a={...a,top:o,right:o,bottom:o,left:o},i(h?{...t,margin:a}:{...t,margin:{...t.margin,[e]:o}})},b=(0,d.select)("core/editor").getEditorSettings().colors;return(0,u.jsxs)(u.Fragment,{children:[(0,u.jsx)("div",{...p,children:(0,u.jsx)(j,{blockId:y,attributes:t,clientId:l})}),(0,u.jsxs)(a.InspectorControls,{group:"settings",children:[(0,u.jsxs)(n.PanelBody,{title:(0,o.__)("General","cozy-addons"),children:[(0,u.jsx)(n.SelectControl,{label:(0,o.__)("Display","cozy-addons"),options:[{label:(0,o.__)("Grid","cozy-addons"),value:"grid"},{label:(0,o.__)("Carousel","cozy-addons"),value:"carousel"}],value:t.display,onChange:o=>{var a;a=o,(0,d.select)("core/block-editor").getBlock(l).innerBlocks.forEach((o=>{(0,d.dispatch)("core/block-editor").replaceBlock(o.clientId,(0,e.createBlock)("cozy-block/"+a,{},o.innerBlocks))})),i({...t,display:o})}}),(0,u.jsx)(n.SelectControl,{label:(0,o.__)("Layout","cozy-addons"),options:[{label:(0,o.__)("Default","cozy-addons"),value:"default"},{label:(0,o.__)("Stacked","cozy-addons"),value:"stacked"},{label:(0,o.__)("Overlay","cozy-addons"),value:"gallery"}],value:t.layout,onChange:e=>{(0,d.select)("core/block-editor").getBlock(l).innerBlocks.forEach((o=>{"gallery"===e?_(o.innerBlocks):k(o.innerBlocks)})),i({...t,layout:e})}}),"stacked"===t.layout&&(0,u.jsx)(u.Fragment,{children:(0,u.jsx)(n.RangeControl,{label:(0,o.__)("Vertical Position","cozy-addons"),min:-300,max:300,step:1,value:t.stackedImage.verticalPosition,onChange:e=>i({...t,stackedImage:{...t.stackedImage,verticalPosition:e}})})})]}),"grid"===t.display&&(0,u.jsxs)(n.PanelBody,{title:(0,o.__)("Grid Options","cozy-addons"),initialOpen:!1,children:[(0,u.jsx)(n.ToggleControl,{label:(0,o.__)("Enable Masonry","cozy-addons"),checked:t.gridOptions.enableMasonry,onChange:e=>i({...t,gridOptions:{...t.gridOptions,enableMasonry:e}})}),(0,u.jsx)(n.RangeControl,{label:(0,o.__)("Column Count","cozy-addons"),min:1,max:10,step:1,value:t.gridOptions.columnCount,onChange:e=>i({...t,gridOptions:{...t.gridOptions,columnCount:Math.abs(e)}})}),(0,u.jsx)(n.RangeControl,{label:(0,o.__)("Gap","cozy-addons"),min:0,max:100,step:1,value:t.gridOptions.gap,onChange:e=>i({...t,gridOptions:{...t.gridOptions,gap:Math.abs(e)}})})]}),"carousel"===t.display&&(0,u.jsxs)(n.PanelBody,{title:(0,o.__)("Carousel Options","cozy-addons"),initialOpen:!1,children:[!cozyBlockAssets.isPremium&&(0,u.jsxs)(u.Fragment,{children:[(0,u.jsxs)(n.BaseControl,{children:[(0,u.jsxs)("div",{style:{display:"flex",gap:"15px"},children:[(0,u.jsx)(n.BaseControl.VisualLabel,{children:(0,o.__)("Slides per View","cozy-addons")}),(0,u.jsx)("p",{className:"cozy-block-pro-label",children:(0,o.__)("PRO","cozy-addons")})]}),(0,u.jsx)(n.RangeControl,{min:1,max:10,value:t.sliderOptions.slidesPerView,help:(0,o.__)("*Note: To enhance the visual impact, activate centered slides and use fractional numbers as input.","cozy-addons"),disabled:!0})]}),(0,u.jsxs)(n.BaseControl,{children:[(0,u.jsxs)("div",{style:{display:"flex",gap:"15px"},children:[(0,u.jsx)(n.BaseControl.VisualLabel,{children:(0,o.__)("Centered Slides","cozy-addons")}),(0,u.jsx)("p",{className:"cozy-block-pro-label",children:(0,o.__)("PRO","cozy-addons")})]}),(0,u.jsx)(n.ToggleControl,{checked:t.sliderOptions.centeredSlides,disabled:!0})]}),(0,u.jsxs)(n.BaseControl,{children:[(0,u.jsxs)("div",{style:{display:"flex",gap:"15px"},children:[(0,u.jsx)(n.BaseControl.VisualLabel,{children:(0,o.__)("Gap","cozy-addons")}),(0,u.jsx)("p",{className:"cozy-block-pro-label",children:(0,o.__)("PRO","cozy-addons")})]}),(0,u.jsx)(n.RangeControl,{value:t.sliderOptions.spaceBetween,disabled:!0,min:0,max:100})]})]}),cozyBlockAssets.isPremium&&(0,u.jsxs)(u.Fragment,{children:[(0,u.jsx)(n.RangeControl,{label:(0,o.__)("Slides per View","cozy-addons"),min:1,max:10,step:.1,value:t.sliderOptions.slidesPerView,onChange:e=>i({...t,sliderOptions:{...t.sliderOptions,slidesPerView:e}}),help:(0,o.__)("*Note: To enhance the visual impact, activate centered slides and use fractional numbers as input.","cozy-addons")}),(0,u.jsx)(n.ToggleControl,{label:(0,o.__)("Centered Slides","cozy-addons"),checked:t.sliderOptions.centeredSlides,onChange:e=>i({...t,sliderOptions:{...t.sliderOptions,centeredSlides:e}})}),(0,u.jsx)(n.RangeControl,{label:(0,o.__)("Gap","cozy-addons"),min:0,step:1,max:100,value:t.sliderOptions.spaceBetween,onChange:e=>i({...t,sliderOptions:{...t.sliderOptions,spaceBetween:Math.abs(e)}})})]}),(0,u.jsx)(n.ToggleControl,{label:(0,o.__)("Loop","cozy-addons"),checked:t.sliderOptions.loop,onChange:e=>i({...t,sliderOptions:{...t.sliderOptions,loop:e}})}),(0,u.jsx)(n.ToggleControl,{label:(0,o.__)("Autoplay","cozy-addons"),checked:t.sliderOptions.autoplay.status,onChange:e=>i({...t,sliderOptions:{...t.sliderOptions,autoplay:{...t.sliderOptions.autoplay,status:e}}})}),t.sliderOptions.autoplay.status&&(0,u.jsxs)(u.Fragment,{children:[(0,u.jsx)(n.RangeControl,{label:(0,o.__)("Autoplay Delay","cozy-addons"),min:0,max:1e4,step:1,value:t.sliderOptions.autoplay.delay,onChange:e=>i({...t,sliderOptions:{...t.sliderOptions,autoplay:{...t.sliderOptions.autoplay,delay:Math.abs(e)}}})}),(0,u.jsx)(n.ToggleControl,{label:(0,o.__)("Reverse Direction","cozy-addons"),checked:t.sliderOptions.autoplay?.reverseDirection,onChange:e=>i({...t,sliderOptions:{...t.sliderOptions,autoplay:{...t.sliderOptions.autoplay,reverseDirection:e}}})})]}),!cozyBlockAssets.isPremium&&(0,u.jsxs)(n.BaseControl,{children:[(0,u.jsxs)("div",{style:{display:"flex",gap:"15px"},children:[(0,u.jsx)(n.BaseControl.VisualLabel,{children:(0,o.__)("Speed (ms)","cozy-addons")}),(0,u.jsx)("p",{className:"cozy-block-pro-label",children:(0,o.__)("PRO","cozy-addons")})]}),(0,u.jsx)(n.RangeControl,{min:0,max:5e3,value:t.sliderOptions.speed,disabled:!0,help:(0,o.__)("*Note: Greater the value, greater the delay.","cozy-addons")})]}),cozyBlockAssets.isPremium&&(0,u.jsx)(n.RangeControl,{label:(0,o.__)("Speed (ms)","cozy-addons"),value:t.sliderOptions.speed,min:0,max:1e4,step:1,onChange:e=>i({...t,sliderOptions:{...t.sliderOptions,speed:Math.abs(e)}}),help:(0,o.__)("*Note: Greater the value, greater the delay.","cozy-addons")}),(0,u.jsx)(n.ToggleControl,{label:(0,o.__)("Enable Pagination","cozy-addons"),checked:t.pagination.enabled,onChange:e=>i({...t,pagination:{...t.pagination,enabled:e}})}),(0,u.jsx)(n.ToggleControl,{label:(0,o.__)("Enable Navigation","cozy-addons"),checked:t.navigation.enabled,onChange:e=>i({...t,navigation:{...t.navigation,enabled:e}})}),t.navigation.enabled&&(0,u.jsx)(n.ToggleControl,{label:(0,o.__)("Display on Hover","cozy-addons"),checked:t.hoverShow,onChange:e=>i({hoverShow:e}),help:(0,o.__)("*Show navigation only after hovering the block.")})]}),!cozyBlockAssets.isPremium&&(0,u.jsx)(m,{})]},"setting"),(0,u.jsxs)(a.InspectorControls,{group:"styles",children:[(0,u.jsx)(n.PanelBody,{title:(0,o.__)("Container Styles","cozy-addons"),children:(0,u.jsxs)(n.BaseControl,{children:[(0,u.jsx)(n.BaseControl.VisualLabel,{children:(0,o.__)("Margin","cozy-addons")}),(0,u.jsxs)("div",{style:{display:"flex",gap:"5px",height:"50px",position:"relative"},children:[(0,u.jsx)("button",{className:"cozy-link-styles "+(h?"":"cozy-attr-link-disabled"),onClick:()=>v(!h),children:(0,u.jsxs)("svg",{width:"10",height:"16",viewBox:"0 0 15 28",fill:"none",xmlns:"http://www.w3.org/2000/svg",children:[(0,u.jsx)("path",{d:"M6.18931 9.59516L6.18931 19.3466H8.70581V9.59516H6.18931Z",fill:"black"}),(0,u.jsx)("path",{d:"M0.0553284 7.88029L0.0553284 13.2126H2.53381L2.53381 7.88029C2.82201 4.53678 5.6079 3.53757 6.94321 3.4415C10.9203 3.15534 12.1019 6.00678 12.3901 7.88029V13.2126L14.8398 13.2126V7.88029C14.1251 1.90809 9.2776 0.780139 6.94321 0.962687C1.84791 1.30857 0.0553284 5.92031 0.0553284 7.88029Z",fill:"black"}),(0,u.jsx)("path",{d:"M0.0553284 20.9042L0.0553284 15.5718H2.53381L2.53381 20.9042C2.82201 24.2477 5.6079 25.2469 6.94321 25.343C10.9203 25.6291 12.1019 22.7777 12.3901 20.9042V15.5718L14.8398 15.5718V20.9042C14.1251 26.8764 9.2776 28.0043 6.94321 27.8218C1.84791 27.4759 0.0553284 22.8641 0.0553284 20.9042Z",fill:"black"})]})}),(0,u.jsx)(n.TextControl,{type:"number",step:1,label:(0,o.__)("Top","cozy-addons"),value:t.margin.top,onChange:e=>x("top",e)}),(0,u.jsx)(n.TextControl,{type:"number",step:1,label:(0,o.__)("Right","cozy-addons"),value:t.margin.right,onChange:e=>x("right",e)}),(0,u.jsx)(n.TextControl,{type:"number",step:1,label:(0,o.__)("Bottom","cozy-addons"),value:t.margin.bottom,onChange:e=>x("bottom",e)}),(0,u.jsx)(n.TextControl,{type:"number",step:1,label:(0,o.__)("Left","cozy-addons"),value:t.margin.left,onChange:e=>x("left",e)})]})]})}),"gallery"===t.layout&&(0,u.jsxs)(n.PanelBody,{title:(0,o.__)("Overlay Styles","cozy-addons"),initialOpen:!1,children:[(0,u.jsx)(n.RangeControl,{label:(0,o.__)("Opacity","cozy-addons"),min:0,max:1,step:.1,value:t.galleryOptions.overlayOpacity,onChange:e=>i({...t,galleryOptions:{...t.galleryOptions,overlayOpacity:e}})}),(0,u.jsx)(a.PanelColorSettings,{className:"cozy-color-control",enableAlpha:!0,title:(0,o.__)("Overlay Color","cozy-addons"),colorSettings:[{label:(0,o.__)("Hover","cozy-addons"),value:t.galleryOptions.overlayColorHover,onChange:e=>i({...t,galleryOptions:{...t.galleryOptions,overlayColorHover:e}})}]})]}),"carousel"===t.display&&(0,u.jsxs)(u.Fragment,{children:[t.pagination.enabled&&(0,u.jsx)(u.Fragment,{children:(0,u.jsxs)(n.PanelBody,{title:(0,o.__)("Pagination Styles","cozy-addons"),initialOpen:!1,children:[(0,u.jsxs)(n.__experimentalToggleGroupControl,{label:(0,o.__)("Align","cozy-addons"),isBlock:!0,value:t.pagination?.align,onChange:e=>i({pagination:{...t.pagination,align:e}}),children:[(0,u.jsx)(n.__experimentalToggleGroupControlOptionIcon,{label:(0,o.__)("Left","cozy-addons"),value:"left",icon:r}),(0,u.jsx)(n.__experimentalToggleGroupControlOptionIcon,{label:(0,o.__)("Center","cozy-addons"),value:"center",icon:s}),(0,u.jsx)(n.__experimentalToggleGroupControlOptionIcon,{label:(0,o.__)("Right","cozy-addons"),value:"right",icon:c})]}),(0,u.jsx)(n.RangeControl,{label:(0,o.__)("Vertical Positioning","cozy-addons"),min:-300,max:300,step:1,value:t.pagination.verticalPosition,onChange:e=>i({...t,pagination:{...t.pagination,verticalPosition:e}})}),"left"===t.pagination?.align&&(0,u.jsx)("div",{className:"components-base-control",children:(0,u.jsx)(a.HeightControl,{label:(0,o.__)("Horizontal Positioning","cozy-addons"),value:t.pagination?.left,onChange:e=>i({...t,pagination:{...t.pagination,left:e}})})}),(0,u.jsx)(n.RangeControl,{label:(0,o.__)("Gap","cozy-addons"),min:0,max:100,step:1,value:t.pagination?.gap,onChange:e=>i({...t,pagination:{...t.pagination,gap:Math.abs(e)}})}),"right"===t.pagination?.align&&(0,u.jsx)("div",{className:"components-base-control",children:(0,u.jsx)(a.HeightControl,{label:(0,o.__)("Horizontal Positioning","cozy-addons"),value:t.pagination?.right,onChange:e=>i({...t,pagination:{...t.pagination,right:e}})})}),(0,u.jsx)(n.TabPanel,{className:"cozy-tab-panel",activeClass:"active-tab",tabs:[{name:"cozy-pagination-width__default",title:(0,o.__)("Default","cozy-addons"),className:"tab-one"},{name:"cozy-pagination-width__active",title:(0,o.__)("Active","cozy-addons"),className:"tab-two"}],children:e=>(0,u.jsxs)(u.Fragment,{children:["cozy-pagination-width__default"===e.name&&(0,u.jsxs)(u.Fragment,{children:[(0,u.jsx)(n.RangeControl,{label:(0,o.__)("Width","cozy-addons"),min:1,max:100,step:1,value:t.pagination.width,onChange:e=>i({...t,pagination:{...t.pagination,width:Math.abs(e)}})}),(0,u.jsx)(n.RangeControl,{label:(0,o.__)("Height","cozy-addons"),min:1,max:100,step:1,value:t.pagination.height,onChange:e=>i({...t,pagination:{...t.pagination,height:Math.abs(e)}})}),(0,u.jsx)(n.RangeControl,{label:(0,o.__)("Border Radius","cozy-addons"),min:0,max:100,step:1,value:t.pagination.borderRadius,onChange:e=>i({...t,pagination:{...t.pagination,borderRadius:Math.abs(e)}})})]}),"cozy-pagination-width__active"===e.name&&(0,u.jsxs)(u.Fragment,{children:[(0,u.jsx)(n.RangeControl,{label:(0,o.__)("Width","cozy-addons"),min:1,max:100,step:1,value:t.pagination.activeWidth,onChange:e=>i({...t,pagination:{...t.pagination,activeWidth:Math.abs(e)}})}),(0,u.jsx)(n.RangeControl,{label:(0,o.__)("Height","cozy-addons"),min:1,max:100,step:1,value:t.pagination?.activeHeight,onChange:e=>i({...t,pagination:{...t.pagination,activeHeight:Math.abs(e)}})}),(0,u.jsx)("div",{className:"components-base-control",children:(0,u.jsx)(n.__experimentalBorderControl,{enableAlpha:!0,colors:b,isCompact:!0,label:(0,o.__)("Border","cozy-addons"),value:t.pagination?.activeBorder,onChange:e=>i({...t,pagination:{...t.pagination,activeBorder:e}})})}),(0,u.jsx)(n.RangeControl,{label:(0,o.__)("Border Offset","cozy-addons"),min:1,max:100,step:1,value:t.pagination?.activeOffset,onChange:e=>i({...t,pagination:{...t.pagination,activeOffset:Math.abs(e)}})}),(0,u.jsx)(n.RangeControl,{label:(0,o.__)("Border Radius","cozy-addons"),min:0,max:100,step:1,value:t.pagination.activeBorderRadius,onChange:e=>i({...t,pagination:{...t.pagination,activeBorderRadius:Math.abs(e)}})})]})]})}),(0,u.jsx)(a.PanelColorSettings,{className:"cozy-color-control",enableAlpha:!0,title:(0,o.__)("Color","cozy-addons"),colorSettings:[{label:(0,o.__)("Default (Normal)","cozy-addons"),value:t.pagination.color,onChange:e=>i({...t,pagination:{...t.pagination,color:e}})},{label:(0,o.__)("Default (Hover)","cozy-addons"),value:t.pagination.colorHover,onChange:e=>i({...t,pagination:{...t.pagination,colorHover:e}})},{label:(0,o.__)("Active (Normal)","cozy-addons"),value:t.pagination.activeColor,onChange:e=>i({...t,pagination:{...t.pagination,activeColor:e}})},{label:(0,o.__)("Active (Hover)","cozy-addons"),value:t.pagination.activeColorHover,onChange:e=>i({...t,pagination:{...t.pagination,activeColorHover:e}})},{label:(0,o.__)("Border (Hover)","cozy-addons"),value:t.pagination?.activeBorderHover,onChange:e=>i({...t,pagination:{...t.pagination,activeBorderHover:e}})}]})]})}),t.navigation.enabled&&(0,u.jsxs)(n.PanelBody,{title:(0,o.__)("Navigation Styles","cozy-addons"),initialOpen:!1,children:[(0,u.jsx)(n.RangeControl,{label:(0,o.__)("Icon Box Width","cozy-addons"),min:1,max:50,step:1,value:t.navigation.iconBoxWidth,onChange:e=>i({...t,navigation:{...t.navigation,iconBoxWidth:Math.abs(e)}})}),(0,u.jsx)(n.RangeControl,{label:(0,o.__)("Icon Box Height","cozy-addons"),min:1,max:50,step:1,value:t.navigation.iconBoxHeight,onChange:e=>i({...t,navigation:{...t.navigation,iconBoxHeight:Math.abs(e)}})}),(0,u.jsx)(n.RangeControl,{label:(0,o.__)("Icon Size","cozy-addons"),min:1,max:50,step:1,value:t.navigation.iconSize,onChange:e=>i({...t,navigation:{...t.navigation,iconSize:Math.abs(e)}})}),(0,u.jsx)("div",{className:"components-base-control",children:(0,u.jsx)(n.__experimentalBorderControl,{enableAlpha:!0,isCompact:!0,colors:b,label:(0,o.__)("Border","cozy-addons"),value:t.navigation?.border,onChange:e=>i({...t,navigation:{...t.navigation,border:e}})})}),(0,u.jsx)(n.RangeControl,{label:(0,o.__)("Border Radius","cozy-addons"),min:0,max:100,step:1,value:t.navigation.borderRadius,onChange:e=>i({...t,navigation:{...t.navigation,borderRadius:Math.abs(e)}})}),(0,u.jsx)(a.PanelColorSettings,{className:"cozy-color-control",enableAlpha:!0,title:(0,o.__)("Color","cozy-addons"),colorSettings:[{label:(0,o.__)("Background (Normal)","cozy-addons"),value:t.navigation.backgroundColor,onChange:e=>i({...t,navigation:{...t.navigation,backgroundColor:e}})},{label:(0,o.__)("Background (Hover)","cozy-addons"),value:t.navigation.backgroundColorHover,onChange:e=>i({...t,navigation:{...t.navigation,backgroundColorHover:e}})},{label:(0,o.__)("Icon (Normal)","cozy-addons"),value:t.navigation.color,onChange:e=>i({...t,navigation:{...t.navigation,color:e}})},{label:(0,o.__)("Icon (Hover)","cozy-addons"),value:t.navigation.colorHover,onChange:e=>i({...t,navigation:{...t.navigation,colorHover:e}})},{label:(0,o.__)("Border (Hover)","cozy-addons"),value:t.navigation?.borderHover,onChange:e=>i({...t,navigation:{...t.navigation,borderHover:e}})}]})]})]})]},"style")]})},save:function({attributes:e}){const o=`cozyBlock_${(n=e.blockClientId,n.replace(/[;=()\s]/g,"")).replace(/-/gi,"_")}`;var n;return(0,u.jsx)(u.Fragment,{children:(0,u.jsxs)("div",{className:`cozy-block-featured-content-box display-${e.display} layout-${e.layout} ${"grid"===e.display&&e.gridOptions.enableMasonry?"has-masonry":""} ${"carousel"===e.display?"cozy-featured-content-box__swiper-container":""} ${e.hoverShow?"hover-show":""}`,id:o,children:[(0,u.jsx)("div",{className:`cozy-${e.display}-wrapper ${"carousel"===e.display?"swiper-wrapper":""}`,children:(0,u.jsx)(a.InnerBlocks.Content,{})}),"carousel"===e.display&&(0,u.jsxs)(u.Fragment,{children:[e.navigation.enabled&&(0,u.jsxs)(u.Fragment,{children:[(0,u.jsx)("div",{className:"swiper-button-prev cozy-block-button-prev"}),(0,u.jsx)("div",{className:"swiper-button-next cozy-block-button-next"})]}),e.pagination.enabled&&(0,u.jsx)("div",{className:"swiper-pagination cozy-pagination"})]})]})})}})}},a={};function n(e){var t=a[e];if(void 0!==t)return t.exports;var i=a[e]={exports:{}};return o[e](i,i.exports,n),i.exports}n.m=o,e=[],n.O=(o,a,t,i)=>{if(!a){var l=1/0;for(d=0;d<e.length;d++){for(var[a,t,i]=e[d],r=!0,s=0;s<a.length;s++)(!1&i||l>=i)&&Object.keys(n.O).every((e=>n.O[e](a[s])))?a.splice(s--,1):(r=!1,i<l&&(l=i));if(r){e.splice(d--,1);var c=t();void 0!==c&&(o=c)}}return o}i=i||0;for(var d=e.length;d>0&&e[d-1][2]>i;d--)e[d]=e[d-1];e[d]=[a,t,i]},n.o=(e,o)=>Object.prototype.hasOwnProperty.call(e,o),(()=>{var e={57:0,350:0};n.O.j=o=>0===e[o];var o=(o,a)=>{var t,i,[l,r,s]=a,c=0;if(l.some((o=>0!==e[o]))){for(t in r)n.o(r,t)&&(n.m[t]=r[t]);if(s)var d=s(n)}for(o&&o(a);c<l.length;c++)i=l[c],n.o(e,i)&&e[i]&&e[i][0](),e[i]=0;return n.O(d)},a=globalThis.webpackChunkfeatured_content_box=globalThis.webpackChunkfeatured_content_box||[];a.forEach(o.bind(null,0)),a.push=o.bind(null,a.push.bind(a))})();var t=n.O(void 0,[350],(()=>n(838)));t=n.O(t)})();