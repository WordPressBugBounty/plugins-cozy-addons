(()=>{"use strict";var e,t={135:()=>{const e=window.wp.blocks,t=window.wp.i18n,o=window.wp.blockEditor,l=window.wp.components,n=window.wp.primitives,a=window.ReactJSXRuntime,s=(0,a.jsx)(n.SVG,{xmlns:"http://www.w3.org/2000/svg",viewBox:"-2 -2 24 24",children:(0,a.jsx)(n.Path,{d:"M10 1c-5 0-9 4-9 9s4 9 9 9 9-4 9-9-4-9-9-9zm0 16c-3.9 0-7-3.1-7-7s3.1-7 7-7 7 3.1 7 7-3.1 7-7 7zm1-11H9v3H6v2h3v3h2v-3h3V9h-3V6zM10 1c-5 0-9 4-9 9s4 9 9 9 9-4 9-9-4-9-9-9zm0 16c-3.9 0-7-3.1-7-7s3.1-7 7-7 7 3.1 7 7-3.1 7-7 7zm1-11H9v3H6v2h3v3h2v-3h3V9h-3V6z"})}),r=window.wp.data,i=window.wp.element,c=(0,a.jsx)(n.SVG,{xmlns:"http://www.w3.org/2000/svg",viewBox:"0 0 24 24",children:(0,a.jsx)(n.Path,{fillRule:"evenodd",d:"M10.289 4.836A1 1 0 0111.275 4h1.306a1 1 0 01.987.836l.244 1.466c.787.26 1.503.679 2.108 1.218l1.393-.522a1 1 0 011.216.437l.653 1.13a1 1 0 01-.23 1.273l-1.148.944a6.025 6.025 0 010 2.435l1.149.946a1 1 0 01.23 1.272l-.653 1.13a1 1 0 01-1.216.437l-1.394-.522c-.605.54-1.32.958-2.108 1.218l-.244 1.466a1 1 0 01-.987.836h-1.306a1 1 0 01-.986-.836l-.244-1.466a5.995 5.995 0 01-2.108-1.218l-1.394.522a1 1 0 01-1.217-.436l-.653-1.131a1 1 0 01.23-1.272l1.149-.946a6.026 6.026 0 010-2.435l-1.148-.944a1 1 0 01-.23-1.272l.653-1.131a1 1 0 011.217-.437l1.393.522a5.994 5.994 0 012.108-1.218l.244-1.466zM14.929 12a3 3 0 11-6 0 3 3 0 016 0z",clipRule:"evenodd"})}),d=(0,a.jsx)(n.SVG,{viewBox:"0 0 24 24",xmlns:"http://www.w3.org/2000/svg",children:(0,a.jsx)(n.Path,{fillRule:"evenodd",clipRule:"evenodd",d:"M20 12a8 8 0 1 1-16 0 8 8 0 0 1 16 0Zm-1.5 0a6.5 6.5 0 0 1-6.5 6.5v-13a6.5 6.5 0 0 1 6.5 6.5Z"})}),g=(0,a.jsx)(n.SVG,{xmlns:"http://www.w3.org/2000/svg",viewBox:"0 0 24 24",children:(0,a.jsx)(n.Path,{d:"M9 9v6h11V9H9zM4 20h1.5V4H4v16z"})}),y=(0,a.jsx)(n.SVG,{xmlns:"http://www.w3.org/2000/svg",viewBox:"0 0 24 24",children:(0,a.jsx)(n.Path,{d:"M12.5 15v5H11v-5H4V9h7V4h1.5v5h7v6h-7Z"})}),p=(0,a.jsx)(n.SVG,{xmlns:"http://www.w3.org/2000/svg",viewBox:"0 0 24 24",children:(0,a.jsx)(n.Path,{d:"M4 15h11V9H4v6zM18.5 4v16H20V4h-1.5z"})}),x=(0,i.memo)((({attributes:e,setAttributes:o})=>(0,a.jsx)(a.Fragment,{children:(0,a.jsx)("div",{children:(0,a.jsx)(l.Panel,{children:(0,a.jsxs)(l.PanelBody,{title:(0,t.__)("General","cozy-addons"),children:[(0,a.jsxs)(l.__experimentalToggleGroupControl,{label:(0,t.__)("Mode","cozy-addons"),value:e.type,onChange:t=>o({...e,type:t}),isBlock:!0,children:[(0,a.jsx)(l.__experimentalToggleGroupControlOption,{label:(0,t.__)("Tab","cozy-addons"),value:"tab"}),(0,a.jsx)(l.__experimentalToggleGroupControlOption,{label:(0,t.__)("Toggle","cozy-addons"),value:"toggle"})]}),(0,a.jsx)("div",{style:{maxWidth:"40%",margin:"16px 0"},children:(0,a.jsx)(l.__experimentalUnitControl,{label:(0,t.__)("Tabs Gap","cozy-addons"),value:e.wrapperStyles.contentGap,onChange:t=>o({...e,wrapperStyles:{...e.wrapperStyles,contentGap:t}}),__next40pxDefaultSize:!0})}),(0,a.jsxs)(l.__experimentalToggleGroupControl,{label:(0,t.__)("Tabs Justification","cozy-addons"),value:e.wrapperStyles.contentAlign,onChange:t=>o({...e,wrapperStyles:{...e.wrapperStyles,contentAlign:t}}),children:[(0,a.jsx)(l.__experimentalToggleGroupControlOptionIcon,{label:(0,t.__)("Left","cozy-addons"),value:"left",icon:g}),(0,a.jsx)(l.__experimentalToggleGroupControlOptionIcon,{label:(0,t.__)("Center","cozy-addons"),value:"center",icon:y}),(0,a.jsx)(l.__experimentalToggleGroupControlOptionIcon,{label:(0,t.__)("Right","cozy-addons"),value:"right",icon:p})]})]})})},"cozy-setting")}))),_=(0,a.jsx)(n.SVG,{xmlns:"http://www.w3.org/2000/svg",viewBox:"0 0 24 24",children:(0,a.jsx)(n.Path,{d:"M5 11.25h14v1.5H5z"})}),b=(0,a.jsx)(n.SVG,{xmlns:"http://www.w3.org/2000/svg",viewBox:"0 0 24 24",children:(0,a.jsx)(n.Path,{d:"M6.1 6.8L2.1 18h1.6l1.1-3h4.3l1.1 3h1.6l-4-11.2H6.1zm-.8 6.8L7 8.9l1.7 4.7H5.3zm15.1-.7c-.4-.5-.9-.8-1.6-1 .4-.2.7-.5.8-.9.2-.4.3-.9.3-1.4 0-.9-.3-1.6-.8-2-.6-.5-1.3-.7-2.4-.7h-3.5V18h4.2c1.1 0 2-.3 2.6-.8.6-.6 1-1.4 1-2.4-.1-.8-.3-1.4-.6-1.9zm-5.7-4.7h1.8c.6 0 1.1.1 1.4.4.3.2.5.7.5 1.3 0 .6-.2 1.1-.5 1.3-.3.2-.8.4-1.4.4h-1.8V8.2zm4 8c-.4.3-.9.5-1.5.5h-2.6v-3.8h2.6c1.4 0 2 .6 2 1.9.1.6-.1 1-.5 1.4z"})}),h=(0,a.jsx)(n.SVG,{xmlns:"http://www.w3.org/2000/svg",viewBox:"0 0 24 24",children:(0,a.jsx)(n.Path,{d:"M11 16.8c-.1-.1-.2-.3-.3-.5v-2.6c0-.9-.1-1.7-.3-2.2-.2-.5-.5-.9-.9-1.2-.4-.2-.9-.3-1.6-.3-.5 0-1 .1-1.5.2s-.9.3-1.2.6l.2 1.2c.4-.3.7-.4 1.1-.5.3-.1.7-.2 1-.2.6 0 1 .1 1.3.4.3.2.4.7.4 1.4-1.2 0-2.3.2-3.3.7s-1.4 1.1-1.4 2.1c0 .7.2 1.2.7 1.6.4.4 1 .6 1.8.6.9 0 1.7-.4 2.4-1.2.1.3.2.5.4.7.1.2.3.3.6.4.3.1.6.1 1.1.1h.1l.2-1.2h-.1c-.4.1-.6 0-.7-.1zM9.2 16c-.2.3-.5.6-.9.8-.3.1-.7.2-1.1.2-.4 0-.7-.1-.9-.3-.2-.2-.3-.5-.3-.9 0-.6.2-1 .7-1.3.5-.3 1.3-.4 2.5-.5v2zm10.6-3.9c-.3-.6-.7-1.1-1.2-1.5-.6-.4-1.2-.6-1.9-.6-.5 0-.9.1-1.4.3-.4.2-.8.5-1.1.8V6h-1.4v12h1.3l.2-1c.2.4.6.6 1 .8.4.2.9.3 1.4.3.7 0 1.2-.2 1.8-.5.5-.4 1-.9 1.3-1.5.3-.6.5-1.3.5-2.1-.1-.6-.2-1.3-.5-1.9zm-1.7 4c-.4.5-.9.8-1.6.8s-1.2-.2-1.7-.7c-.4-.5-.7-1.2-.7-2.1 0-.9.2-1.6.7-2.1.4-.5 1-.7 1.7-.7s1.2.3 1.6.8c.4.5.6 1.2.6 2s-.2 1.4-.6 2z"})}),u=(0,a.jsx)(n.SVG,{xmlns:"http://www.w3.org/2000/svg",viewBox:"0 0 24 24",children:(0,a.jsx)(n.Path,{d:"M7.1 6.8L3.1 18h1.6l1.1-3h4.3l1.1 3h1.6l-4-11.2H7.1zm-.8 6.8L8 8.9l1.7 4.7H6.3zm14.5-1.5c-.3-.6-.7-1.1-1.2-1.5-.6-.4-1.2-.6-1.9-.6-.5 0-.9.1-1.4.3-.4.2-.8.5-1.1.8V6h-1.4v12h1.3l.2-1c.2.4.6.6 1 .8.4.2.9.3 1.4.3.7 0 1.2-.2 1.8-.5.5-.4 1-.9 1.3-1.5.3-.6.5-1.3.5-2.1-.1-.6-.2-1.3-.5-1.9zm-1.7 4c-.4.5-.9.8-1.6.8s-1.2-.2-1.7-.7c-.4-.5-.7-1.2-.7-2.1 0-.9.2-1.6.7-2.1.4-.5 1-.7 1.7-.7s1.2.3 1.6.8c.4.5.6 1.2.6 2 .1.8-.2 1.4-.6 2z"})}),m=(0,a.jsx)(n.SVG,{xmlns:"http://www.w3.org/2000/svg",viewBox:"0 0 24 24",children:(0,a.jsx)(n.Path,{d:"M7 18v1h10v-1H7zm5-2c1.5 0 2.6-.4 3.4-1.2.8-.8 1.1-2 1.1-3.5V5H15v5.8c0 1.2-.2 2.1-.6 2.8-.4.7-1.2 1-2.4 1s-2-.3-2.4-1c-.4-.7-.6-1.6-.6-2.8V5H7.5v6.2c0 1.5.4 2.7 1.1 3.5.8.9 1.9 1.3 3.4 1.3z"})}),v=(0,a.jsx)(n.SVG,{xmlns:"http://www.w3.org/2000/svg",viewBox:"0 0 24 24",children:(0,a.jsx)(n.Path,{d:"M9.1 9v-.5c0-.6.2-1.1.7-1.4.5-.3 1.2-.5 2-.5.7 0 1.4.1 2.1.3.7.2 1.4.5 2.1.9l.2-1.9c-.6-.3-1.2-.5-1.9-.7-.8-.1-1.6-.2-2.4-.2-1.5 0-2.7.3-3.6 1-.8.7-1.2 1.5-1.2 2.6V9h2zM20 12H4v1h8.3c.3.1.6.2.8.3.5.2.9.5 1.1.8.3.3.4.7.4 1.2 0 .7-.2 1.1-.8 1.5-.5.3-1.2.5-2.1.5-.8 0-1.6-.1-2.4-.3-.8-.2-1.5-.5-2.2-.8L7 18.1c.5.2 1.2.4 2 .6.8.2 1.6.3 2.4.3 1.7 0 3-.3 3.9-1 .9-.7 1.3-1.6 1.3-2.8 0-.9-.2-1.7-.7-2.2H20v-1z"})}),S=[{label:(0,t.__)("Thin","cozy-addons"),value:"100"},{label:(0,t.__)("Extra Light","cozy-addons"),value:"200"},{label:(0,t.__)("Light","cozy-addons"),value:"300"},{label:(0,t.__)("Normal","cozy-addons"),value:"400"},{label:(0,t.__)("Medium","cozy-addons"),value:"500"},{label:(0,t.__)("Semi Bold","cozy-addons"),value:"600"},{label:(0,t.__)("Bold","cozy-addons"),value:"700"},{label:(0,t.__)("Extra Bold","cozy-addons"),value:"800"},{label:(0,t.__)("Black","cozy-addons"),value:"900"}],z=(0,i.memo)((({attributes:e,setAttributes:n})=>{const s=function(){let e=[{label:"Default",value:""}];if("object"==typeof cozyBlockAssets.googleFonts)for(let t in cozyBlockAssets.googleFonts)e.push({label:cozyBlockAssets.googleFonts[t],value:t});return e}(),i=(0,r.select)("core/editor").getEditorSettings().colors;return(0,a.jsx)(a.Fragment,{children:(0,a.jsxs)("div",{className:"has-light-border-top",children:[(0,a.jsxs)("div",{style:{padding:"0 20px 20px"},children:[(0,a.jsx)(o.PanelColorSettings,{className:"cozy-color-control border-none",enableAlpha:!0,title:(0,t.__)("Color","cozy-addons"),colorSettings:[{label:(0,t.__)("Text","cozy-addons"),value:e.color.text,onChange:t=>n({...e,color:{...e.color,text:t}})},{label:(0,t.__)("Background","cozy-addons"),value:e.color.bg,onChange:t=>n({...e,color:{...e.color,bg:t}})}]}),(0,a.jsx)(l.SelectControl,{label:(0,t.__)("Font Family","cozy-addons"),options:s,value:e.font.family,onChange:t=>n({...e,font:{...e.font,family:t}}),__next40pxDefaultSize:!0}),(0,a.jsxs)("div",{className:"cozy-block-styles__div-separator",children:[(0,a.jsx)("div",{style:{width:"100%"},children:(0,a.jsx)(l.__experimentalUnitControl,{label:(0,t.__)("Font Size","cozy-addons"),min:0,value:e.font.size,onChange:t=>n({...e,font:{...e.font,size:t}}),__next40pxDefaultSize:!0})}),(0,a.jsx)("div",{style:{width:"100%"},children:(0,a.jsx)(l.SelectControl,{label:(0,t.__)("Font Weight","cozy-addons"),options:S,value:e.font.weight,onChange:t=>n({...e,font:{...e.font,weight:t}}),__next40pxDefaultSize:!0})})]})]}),(0,a.jsx)(l.Panel,{children:(0,a.jsxs)(l.PanelBody,{title:(0,t.__)("Spacing","cozy-addons"),initialOpen:!1,children:[(0,a.jsx)("div",{className:"cozy-box-control",style:{marginTop:"16px"},children:(0,a.jsx)(l.__experimentalBoxControl,{label:(0,t.__)("Padding","cozy-addons"),resetValues:{top:"0px",right:"0px",bottom:"0px",left:"0px"},values:e.padding,onChange:t=>n({...e,padding:t})})}),(0,a.jsxs)("div",{className:"cozy-block-styles__div-separator",style:{margin:"16px 0"},children:[(0,a.jsx)("div",{style:{width:"100%"},children:(0,a.jsx)(l.__experimentalUnitControl,{label:(0,t.__)("Margin Top","cozy-addons"),value:e.margin.top,onChange:t=>n({...e,margin:{...e.margin,top:t}}),__next40pxDefaultSize:!0})}),(0,a.jsx)("div",{style:{width:"100%"},children:(0,a.jsx)(l.__experimentalUnitControl,{label:(0,t.__)("Margin Bottom","cozy-addons"),value:e.margin.bottom,onChange:t=>n({...e,margin:{...e.margin,bottom:t}}),__next40pxDefaultSize:!0})})]})]})}),(0,a.jsx)(l.Panel,{children:(0,a.jsxs)(l.PanelBody,{title:(0,t.__)("Border & Radius","cozy-addons"),initialOpen:!1,children:[(0,a.jsx)("div",{style:{marginTop:"16px"},children:(0,a.jsx)(l.__experimentalBorderBoxControl,{className:"cozy-box-control",enableAlpha:!0,colors:i,label:(0,t.__)("Border","cozy-addons"),value:e.border,onChange:t=>n({...e,border:t})})}),(0,a.jsx)("div",{className:"cozy-box-control",style:{margin:"30px 0 16px"},children:(0,a.jsx)(l.__experimentalBoxControl,{label:(0,t.__)("Radius","cozy-addons"),resetValues:[{top:"0px",right:"0px",bottom:"0px",left:"0px"}],values:e.radius,onChange:t=>n({...e,radius:t})})}),(0,a.jsx)(l.ToggleControl,{label:(0,t.__)("Enable Box Shadow","cozy-addons"),checked:e.shadow.enabled,onChange:t=>n({...e,shadow:{...e.shadow,enabled:t}})}),e.shadow.enabled&&(0,a.jsxs)(a.Fragment,{children:[(0,a.jsxs)(l.__experimentalToggleGroupControl,{label:(0,t.__)("Position","cozy-addons"),value:e.shadow.position,onChange:t=>n({...e,shadow:{...e.shadow,position:t}}),isBlock:!0,__next40pxDefaultSize:!0,children:[(0,a.jsx)(l.__experimentalToggleGroupControlOption,{label:(0,t.__)("Inset","cozy-addons"),value:""}),(0,a.jsx)(l.__experimentalToggleGroupControlOption,{label:(0,t.__)("Outline","cozy-addons"),value:"outline"})]}),(0,a.jsxs)("div",{className:"cozy-block-styles__div-separator",children:[(0,a.jsx)("div",{style:{width:"100%"},children:(0,a.jsx)(l.__experimentalUnitControl,{label:(0,t.__)("Horizontal","cozy-addons"),min:-100,max:100,step:1,value:e.shadow.horizontal,onChange:t=>n({...e,shadow:{...e.shadow,horizontal:t}}),__next40pxDefaultSize:!0})}),(0,a.jsx)("div",{style:{width:"100%"},children:(0,a.jsx)(l.__experimentalUnitControl,{label:(0,t.__)("Vertical","cozy-addons"),min:-100,max:100,step:1,value:e.shadow.vertical,onChange:t=>n({...e,shadow:{...e.shadow,vertical:t}}),__next40pxDefaultSize:!0})})]}),(0,a.jsxs)("div",{className:"cozy-block-styles__div-separator",style:{margin:"16px 0"},children:[(0,a.jsx)("div",{style:{width:"100%"},children:(0,a.jsx)(l.__experimentalUnitControl,{label:(0,t.__)("Blur","cozy-addons"),min:0,max:100,step:1,value:e.shadow.blur,onChange:t=>n({...e,shadow:{...e.shadow,blur:t}}),__next40pxDefaultSize:!0})}),(0,a.jsx)("div",{style:{width:"100%"},children:(0,a.jsx)(l.__experimentalUnitControl,{label:(0,t.__)("Spread","cozy-addons"),min:-100,max:100,step:1,value:e.shadow.spread,onChange:t=>n({...e,shadow:{...e.shadow,spread:t}}),__next40pxDefaultSize:!0})})]}),(0,a.jsx)(l.ColorPalette,{title:(0,t.__)("Shadow Color","cozy-addons"),colors:i,value:e.shadow.color,onChange:t=>n({...e,shadow:{...e.shadow,color:t}})})]})]})}),(0,a.jsx)(l.Panel,{children:(0,a.jsxs)(l.PanelBody,{title:(0,t.__)("Header Styles","cozy-addons"),initialOpen:!1,children:[(0,a.jsxs)(l.__experimentalToggleGroupControl,{label:(0,t.__)("Width","cozy-addons"),value:e.wrapperStyles.width,onChange:t=>n({...e,wrapperStyles:{...e.wrapperStyles,width:t}}),isBlock:!0,__next40pxDefaultSize:!0,children:[(0,a.jsx)(l.__experimentalToggleGroupControlOption,{label:(0,t.__)("Default","cozy-addons"),value:"100%"}),(0,a.jsx)(l.__experimentalToggleGroupControlOption,{label:(0,t.__)("Fit Content","cozy-addons"),value:"fit-content"})]}),(0,a.jsx)("div",{className:"cozy-box-control",children:(0,a.jsx)(l.__experimentalBoxControl,{label:(0,t.__)("Padding","cozy-addons"),resetValues:[{top:"0px",right:"0px",bottom:"0px",left:"0px"}],values:e.wrapperStyles.padding,onChange:t=>n({...e,wrapperStyles:{...e.wrapperStyles,padding:t}})})}),(0,a.jsxs)("div",{className:"cozy-block-styles__div-separator",style:{margin:"16px 0"},children:[(0,a.jsx)("div",{style:{width:"100%"},children:(0,a.jsx)(l.__experimentalUnitControl,{label:(0,t.__)("Margin Top"),value:e.wrapperStyles.margin.top,onChange:t=>n({...e,wrapperStyles:{...e.wrapperStyles,margin:{...e.wrapperStyles.margin,top:t}}}),__next40pxDefaultSize:!0})}),(0,a.jsx)("div",{style:{width:"100%"},children:(0,a.jsx)(l.__experimentalUnitControl,{label:(0,t.__)("Margin Bottom"),value:e.wrapperStyles.margin.bottom,onChange:t=>n({...e,wrapperStyles:{...e.wrapperStyles,margin:{...e.wrapperStyles.margin,bottom:t}}}),__next40pxDefaultSize:!0})})]}),(0,a.jsx)(l.__experimentalBorderBoxControl,{className:"cozy-box-control",enableAlpha:!0,label:(0,t.__)("Border","cozy-addons"),colors:i,value:e.wrapperStyles.border,onChange:t=>n({...e,wrapperStyles:{...e.wrapperStyles,border:t}})}),(0,a.jsx)("div",{className:"cozy-box-control",style:{margin:"30px 0 16px"},children:(0,a.jsx)(l.__experimentalBoxControl,{label:(0,t.__)("Border Radius","cozy-addons"),resetValues:[{top:"0px",right:"0px",bottom:"0px",left:"0px"}],values:e.wrapperStyles.radius,onChange:t=>n({...e,wrapperStyles:{...e.wrapperStyles,radius:t}})})}),(0,a.jsx)(o.PanelColorSettings,{className:"cozy-color-control",enableAlpha:!0,title:(0,t.__)("Color","cozy-addons"),colorSettings:[{label:(0,t.__)("Background","cozy-addons"),value:e.wrapperStyles.color.bg,onChange:t=>n({...e,wrapperStyles:{...e.wrapperStyles,color:{...e.wrapperStyles.color,bg:t}}})}]})]})}),"tab"===e.type&&(0,a.jsx)(l.Panel,{children:(0,a.jsxs)(l.PanelBody,{title:(0,t.__)("Tab Styles","cozy-addons"),initialOpen:!1,children:[(0,a.jsx)(l.TabPanel,{className:"cozy-tab-panel",tabs:[{title:(0,t.__)("Default","cozy-addons"),name:"cozy-tab__one"},{title:(0,t.__)("Active","cozy-addons"),name:"cozy-tab__two"}],activeClass:"active-tab",children:o=>(0,a.jsxs)(a.Fragment,{children:["cozy-tab__one"===o.name&&(0,a.jsxs)(a.Fragment,{children:[(0,a.jsx)("div",{className:"cozy-box-control",children:(0,a.jsx)(l.__experimentalBoxControl,{label:(0,t.__)("Padding","cozy-addons"),resetValues:[{top:"0px",right:"0px",bottom:"0px",left:"0px"}],values:e.tabStyles.default.padding,onChange:t=>n({...e,tabStyles:{...e.tabStyles,default:{...e.tabStyles.default,padding:t}}})})}),(0,a.jsx)("div",{style:{margin:"16px 0"},children:(0,a.jsx)(l.__experimentalBorderBoxControl,{className:"cozy-box-control",enableAlpha:!0,colors:i,label:(0,t.__)("Border","cozy-addons"),value:e.tabStyles.default.border,onChange:t=>n({...e,tabStyles:{...e.tabStyles,default:{...e.tabStyles.default,border:t}}})})}),(0,a.jsx)("div",{style:{maxWidth:"40%",margin:"30px 0 20px"},children:(0,a.jsx)(l.__experimentalUnitControl,{label:(0,t.__)("Border Radius","cozy-addons"),value:e.tabStyles.default.radius,onChange:t=>n({...e,tabStyles:{...e.tabStyles,default:{...e.tabStyles.default,radius:t}}}),__next40pxDefaultSize:!0})})]}),"cozy-tab__two"===o.name&&(0,a.jsxs)(a.Fragment,{children:[(0,a.jsxs)("div",{className:"cozy-block-styles__div-separator",children:[(0,a.jsx)("div",{style:{width:"100%"},children:(0,a.jsx)(l.__experimentalUnitControl,{label:(0,t.__)("Margin Top","cozy-addons"),value:e.tabStyles.active.margin.top,onChange:t=>n({...e,tabStyles:{...e.tabStyles,active:{...e.tabStyles.active,margin:{...e.tabStyles.active.margin,top:t}}}}),__next40pxDefaultSize:!0})}),(0,a.jsx)("div",{style:{width:"100%"},children:(0,a.jsx)(l.__experimentalUnitControl,{label:(0,t.__)("Margin Bottom","cozy-addons"),value:e.tabStyles.active.margin.bottom,onChange:t=>n({...e,tabStyles:{...e.tabStyles,active:{...e.tabStyles.active,margin:{...e.tabStyles.active.margin,bottom:t}}}}),__next40pxDefaultSize:!0})})]}),(0,a.jsx)("div",{style:{margin:"16px 0"},children:(0,a.jsx)(l.__experimentalBorderBoxControl,{className:"cozy-box-control",enableAlpha:!0,label:(0,t.__)("Border","cozy-addons"),colors:i,value:e.tabStyles.active.border,onChange:t=>n({...e,tabStyles:{...e.tabStyles,active:{...e.tabStyles.active,border:t}}})})}),(0,a.jsx)("div",{style:{maxWidth:"40%",margin:"30px 0 20px"},children:(0,a.jsx)(l.__experimentalUnitControl,{label:(0,t.__)("Border Radius","cozy-addons"),value:e.tabStyles.active.radius,onChange:t=>n({...e,tabStyles:{...e.tabStyles,active:{...e.tabStyles.active,radius:t}}}),__next40pxDefaultSize:!0})})]})]})}),(0,a.jsx)(l.SelectControl,{label:(0,t.__)("Font Family","cozy-addons"),options:s,value:e.tabStyles.font.family,onChange:t=>n({...e,tabStyles:{...e.tabStyles,font:{...e.tabStyles.font,family:t}}}),__next40pxDefaultSize:!0}),(0,a.jsxs)("div",{className:"cozy-block-styles__div-separator",style:{margin:"16px 0"},children:[(0,a.jsx)("div",{style:{width:"100%"},children:(0,a.jsx)(l.__experimentalUnitControl,{label:(0,t.__)("Font Size","cozy-addons"),value:e.tabStyles.font.size,onChange:t=>n({...e,tabStyles:{...e.tabStyles,font:{...e.tabStyles.font,size:t}}}),__next40pxDefaultSize:!0})}),(0,a.jsx)("div",{style:{width:"100%"},children:(0,a.jsx)(l.SelectControl,{label:(0,t.__)("Font Weight","cozy-addons"),options:S,value:e.tabStyles.font.weight,onChange:t=>n({...e,tabStyles:{...e.tabStyles,font:{...e.tabStyles.font,weight:t}}}),__next40pxDefaultSize:!0})})]}),(0,a.jsxs)("div",{className:"cozy-block-styles__div-separator",children:[(0,a.jsx)("div",{style:{width:"100%"},children:(0,a.jsxs)(l.__experimentalToggleGroupControl,{label:(0,t.__)("Letter Case","cozy-addons"),value:e.tabStyles.letterCase,onChange:t=>n({...e,tabStyles:{...e.tabStyles,letterCase:t}}),children:[(0,a.jsx)(l.__experimentalToggleGroupControlOptionIcon,{label:(0,t.__)("None","cozy-addons"),value:"none",icon:_}),(0,a.jsx)(l.__experimentalToggleGroupControlOptionIcon,{label:(0,t.__)("Uppercase","cozy-addons"),value:"uppercase",icon:b}),(0,a.jsx)(l.__experimentalToggleGroupControlOptionIcon,{label:(0,t.__)("Lowercase","cozy-addons"),value:"lowercase",icon:h}),(0,a.jsx)(l.__experimentalToggleGroupControlOptionIcon,{label:(0,t.__)("Capitalize","cozy-addons"),value:"capitalize",icon:u})]})}),(0,a.jsx)("div",{style:{width:"100%"},children:(0,a.jsxs)(l.__experimentalToggleGroupControl,{label:(0,t.__)("Decoration","cozy-addons"),value:e.tabStyles.decoration,onChange:t=>n({...e,tabStyles:{...e.tabStyles,decoration:t}}),children:[(0,a.jsx)(l.__experimentalToggleGroupControlOptionIcon,{label:(0,t.__)("None","cozy-addons"),value:"none",icon:_}),(0,a.jsx)(l.__experimentalToggleGroupControlOptionIcon,{label:(0,t.__)("Underline","cozy-addons"),value:"underline",icon:m}),(0,a.jsx)(l.__experimentalToggleGroupControlOptionIcon,{label:(0,t.__)("Strikethrough","cozy-addons"),value:"line-through",icon:v})]})})]}),(0,a.jsxs)("div",{className:"cozy-block-styles__div-separator",style:{margin:"16px 0 22px"},children:[(0,a.jsx)("div",{style:{width:"100%"},children:(0,a.jsx)(l.__experimentalUnitControl,{label:(0,t.__)("Line Height","cozy-addons"),value:e.tabStyles.lineHeight,onChange:t=>n({...e,tabStyles:{...e.tabStyles,lineHeight:t}}),__next40pxDefaultSize:!0})}),(0,a.jsx)("div",{style:{width:"100%"},children:(0,a.jsx)(l.__experimentalUnitControl,{label:(0,t.__)("Letter Spacing","cozy-addons"),value:e.tabStyles.letterSpacing,onChange:t=>n({...e,tabStyles:{...e.tabStyles,letterSpacing:t}}),__next40pxDefaultSize:!0})})]}),(0,a.jsx)(o.PanelColorSettings,{className:"cozy-color-control",enableAlpha:!0,title:(0,t.__)("Color","cozy-addons"),colorSettings:[{label:(0,t.__)("Text","cozy-addons"),value:e.tabStyles.color.text,onChange:t=>n({...e,tabStyles:{...e.tabStyles,color:{...e.tabStyles.color,text:t}}})},{label:(0,t.__)("Text (Active)","cozy-addons"),value:e.tabStyles.color.textActive,onChange:t=>n({...e,tabStyles:{...e.tabStyles,color:{...e.tabStyles.color,textActive:t}}})},{label:(0,t.__)("Text (Hover)","cozy-addons"),value:e.tabStyles.color.textHover,onChange:t=>n({...e,tabStyles:{...e.tabStyles,color:{...e.tabStyles.color,textHover:t}}})},{label:(0,t.__)("Background","cozy-addons"),value:e.tabStyles.color.bg,onChange:t=>n({...e,tabStyles:{...e.tabStyles,color:{...e.tabStyles.color,bg:t}}})},{label:(0,t.__)("Background (Active)","cozy-addons"),value:e.tabStyles.color.bgActive,onChange:t=>n({...e,tabStyles:{...e.tabStyles,color:{...e.tabStyles.color,bgActive:t}}})},{label:(0,t.__)("Background (Hover)","cozy-addons"),value:e.tabStyles.color.bgHover,onChange:t=>n({...e,tabStyles:{...e.tabStyles,color:{...e.tabStyles.color,bgHover:t}}})},{label:(0,t.__)("Border (Hover)","cozy-addons"),value:e.tabStyles.color.borderHover,onChange:t=>n({...e,tabStyles:{...e.tabStyles,color:{...e.tabStyles.color,borderHover:t}}})}]})]})}),"toggle"===e.type&&(0,a.jsx)(l.Panel,{children:(0,a.jsxs)(l.PanelBody,{title:(0,t.__)("Toggle Switcher Styles","cozy-addons"),initialOpen:!1,children:[(0,a.jsx)(l.SelectControl,{label:(0,t.__)("Font Family","cozy-addons"),options:s,value:e.toggleStyles.font.family,onChange:t=>n({...e,toggleStyles:{...e.toggleStyles,font:{...e.toggleStyles.font,family:t}}}),__next40pxDefaultSize:!0}),(0,a.jsxs)("div",{className:"cozy-block-styles__div-separator",style:{margin:"16px 0"},children:[(0,a.jsx)("div",{style:{width:"100%"},children:(0,a.jsx)(l.__experimentalUnitControl,{label:(0,t.__)("Font Size","cozy-addons"),value:e.toggleStyles.font.size,onChange:t=>n({...e,toggleStyles:{...e.toggleStyles,font:{...e.toggleStyles.font,size:t}}}),__next40pxDefaultSize:!0})}),(0,a.jsx)("div",{style:{width:"100%"},children:(0,a.jsx)(l.SelectControl,{label:(0,t.__)("Font Weight","cozy-addons"),options:S,value:e.toggleStyles.font.weight,onChange:t=>n({...e,toggleStyles:{...e.toggleStyles,font:{...e.toggleStyles.font,weight:t}}}),__next40pxDefaultSize:!0})})]}),(0,a.jsxs)("div",{className:"cozy-block-styles__div-separator",children:[(0,a.jsx)("div",{style:{width:"100%"},children:(0,a.jsxs)(l.__experimentalToggleGroupControl,{label:(0,t.__)("Letter Case","cozy-addons"),value:e.toggleStyles.letterCase,onChange:t=>n({...e,toggleStyles:{...e.toggleStyles,letterCase:t}}),children:[(0,a.jsx)(l.__experimentalToggleGroupControlOptionIcon,{label:(0,t.__)("None","cozy-addons"),value:"none",icon:_}),(0,a.jsx)(l.__experimentalToggleGroupControlOptionIcon,{label:(0,t.__)("Uppercase","cozy-addons"),value:"uppercase",icon:b}),(0,a.jsx)(l.__experimentalToggleGroupControlOptionIcon,{label:(0,t.__)("Lowercase","cozy-addons"),value:"lowercase",icon:h}),(0,a.jsx)(l.__experimentalToggleGroupControlOptionIcon,{label:(0,t.__)("Capitalize","cozy-addons"),value:"capitalize",icon:u})]})}),(0,a.jsx)("div",{style:{width:"100%"},children:(0,a.jsxs)(l.__experimentalToggleGroupControl,{label:(0,t.__)("Decoration","cozy-addons"),value:e.toggleStyles.decoration,onChange:t=>n({...e,toggleStyles:{...e.toggleStyles,decoration:t}}),children:[(0,a.jsx)(l.__experimentalToggleGroupControlOptionIcon,{label:(0,t.__)("None","cozy-addons"),value:"none",icon:_}),(0,a.jsx)(l.__experimentalToggleGroupControlOptionIcon,{label:(0,t.__)("Underline","cozy-addons"),value:"underline",icon:m}),(0,a.jsx)(l.__experimentalToggleGroupControlOptionIcon,{label:(0,t.__)("Strikethrough","cozy-addons"),value:"line-through",icon:v})]})})]}),(0,a.jsxs)("div",{className:"cozy-block-styles__div-separator",style:{margin:"16px 0 22px"},children:[(0,a.jsx)("div",{style:{width:"100%"},children:(0,a.jsx)(l.__experimentalUnitControl,{label:(0,t.__)("Line Height","cozy-addons"),value:e.toggleStyles.lineHeight,onChange:t=>n({...e,toggleStyles:{...e.toggleStyles,lineHeight:t}}),__next40pxDefaultSize:!0})}),(0,a.jsx)("div",{style:{width:"100%"},children:(0,a.jsx)(l.__experimentalUnitControl,{label:(0,t.__)("Letter Spacing","cozy-addons"),value:e.toggleStyles.letterSpacing,onChange:t=>n({...e,toggleStyles:{...e.toggleStyles,letterSpacing:t}}),__next40pxDefaultSize:!0})})]}),(0,a.jsx)(o.PanelColorSettings,{className:"cozy-color-control",enableAlpha:!0,title:(0,t.__)("Color","cozy-addons"),colorSettings:[{label:(0,t.__)("Button","cozy-addons"),value:e.toggleStyles.color.button,onChange:t=>n({...e,toggleStyles:{...e.toggleStyles,color:{...e.toggleStyles.color,button:t}}})},{label:(0,t.__)("Background","cozy-addons"),value:e.toggleStyles.color.bg,onChange:t=>n({...e,toggleStyles:{...e.toggleStyles,color:{...e.toggleStyles.color,bg:t}}})},{label:(0,t.__)("Button (Active)","cozy-addons"),value:e.toggleStyles.color.buttonActive,onChange:t=>n({...e,toggleStyles:{...e.toggleStyles,color:{...e.toggleStyles.color,buttonActive:t}}})},{label:(0,t.__)("Background (Active)","cozy-addons"),value:e.toggleStyles.color.bgActive,onChange:t=>n({...e,toggleStyles:{...e.toggleStyles,color:{...e.toggleStyles.color,bgActive:t}}})}]})]})})]},"cozy-style")})})),w=(0,i.memo)((({attributes:e,setAttributes:n})=>(0,a.jsx)(a.Fragment,{children:(0,a.jsx)(o.InspectorControls,{children:(0,a.jsx)(l.TabPanel,{tabs:[{title:(0,t.__)("Settings","cozy-addons"),icon:c,className:"cozy-block__tab-control cozy-block-control__settings",name:"setting"},{title:(0,t.__)("Styles","cozy-addons"),icon:d,className:"cozy-block__tab-control cozy-block-control__styles",name:"style"}],children:t=>(0,a.jsxs)(a.Fragment,{children:["setting"===t.name&&(0,a.jsx)(x,{attributes:e,setAttributes:n}),"style"===t.name&&(0,a.jsx)(z,{attributes:e,setAttributes:n})]})})})})));function j(e,t){return t&&Object.keys(t).length<4?1===Object.keys(t).length?`\n      ${e}: ${t};\n    `:`\n      ${e}: ${t.width} ${t.style} ${t.color};\n    `:t&&4===Object.keys(t).length?"border"===e?`\n        border-top: ${t.top.width} ${t.top.style} ${t.top.color};\n        border-right: ${t.right.width} ${t.right.style} ${t.right.color};\n        border-bottom: ${t.bottom.width} ${t.bottom.style} ${t.bottom.color};\n        border-left: ${t.left.width} ${t.left.style} ${t.left.color};\n      `:`\n    ${e}: ${t.top} ${t.right} ${t.bottom} ${t.left};\n  `:""}function C(e,t){return`\n    #${e} {\n      ${j("padding",t.padding)}     \n      margin-top: ${t.margin.top};       \n      margin-bottom: ${t.margin.bottom}; \n      ${j("border",t.border)}\n      ${j("border-radius",t.radius)}\n      background-color: ${t.color.bg};\n      color: ${t.color.text};\n      font-size: ${t.font.size};\n      font-weight: ${t.font.weight};\n      font-family: ${t.font.family};\n\n      &.has-box-shadow {\n        box-shadow: ${t.shadow.horizontal} ${t.shadow.vertical} ${t.shadow.blur} ${t.shadow.spread} ${t.shadow.color} ${t.shadow.position};\n      }\n    }\n\n    #${e} .toggle-content__header {\n      margin-top: ${t.wrapperStyles.margin.top};\n      margin-bottom: ${t.wrapperStyles.margin.bottom};\n    }\n\n    #${e} .toggle-content__tabs, #${e} .toggle-content__slider {\n      width: ${t.wrapperStyles.width};\n      ${j("padding",t.wrapperStyles.padding)}\n      ${j("border",t.wrapperStyles.border)}      \n      ${j("border-radius",t.wrapperStyles.radius)}\n      justify-content: ${t.wrapperStyles.contentAlign};\n      gap: ${t.wrapperStyles.contentGap};\n      background-color: ${t.wrapperStyles.color.bg};\n    }\n\n    #${e} .toggle-content__tabs .tab-item {\n      ${j("padding",t.tabStyles.default.padding)}\n      ${j("border",t.tabStyles.default.border)}\n      border-radius: ${t.tabStyles.default.radius};\n      background-color: ${t.tabStyles.color.bg};\n      color: ${t.tabStyles.color.text};\n      font-size: ${t.tabStyles.font.size};      \n      font-weight: ${t.tabStyles.font.weight};\n      font-family: ${t.tabStyles.font.family};\n      text-transform: ${t.tabStyles.letterCase};\n      text-decoration: ${t.tabStyles.decoration};\n      line-height: ${t.tabStyles.lineHeight};\n      letter-spacing: ${t.tabStyles.letterSpacing};\n\n      &:hover {\n        background-color: ${t.tabStyles.color.bgHover};\n        color: ${t.tabStyles.color.textHover};\n        border-color: ${t.tabStyles.color.borderHover};\n      }\n\n      &.active-tab {\n        margin-top: ${t.tabStyles.active.margin.top};\n        margin-bottom: ${t.tabStyles.active.margin.bottom};\n        ${j("border",t.tabStyles.active.border)}\n        border-radius: ${t.tabStyles.active.radius};\n        background-color: ${t.tabStyles.color.bgActive};\n        color: ${t.tabStyles.color.textActive};\n      }\n    }\n\n    #${e} .toggle-content__slider {\n      font-size: ${t.toggleStyles.font.size};      \n      font-weight: ${t.toggleStyles.font.weight};\n      font-family: ${t.toggleStyles.font.family};\n      text-transform: ${t.toggleStyles.letterCase};\n      text-decoration: ${t.toggleStyles.decoration};\n      line-height: ${t.toggleStyles.lineHeight};\n      letter-spacing: ${t.toggleStyles.letterSpacing};\n\n      & .slider {\n        background-color: ${t.toggleStyles.color.bg};\n\n        &:before {\n          background-color: ${t.toggleStyles.color.button};\n        }\n      }\n\n      & input:checked + .slider {\n        background-color: ${t.toggleStyles.color.bgActive};\n\n      }\n\n      & input:checked + .slider:before {\n        background-color: ${t.toggleStyles.color.buttonActive};\n\n      }\n    }\n    `}const f=(0,i.memo)((()=>{const e=(0,o.useInnerBlocksProps)({className:"cozy-block-wrapper"},{allowedBlocks:[["cozy-block/toggle-content-item"]],template:[["cozy-block/toggle-content-item"],["cozy-block/toggle-content-item"]],renderAppender:!1});return(0,a.jsx)("div",{...e})})),k=(0,i.memo)((({clientId:n})=>{const{insertBlock:i,selectBlock:c}=(0,r.dispatch)(o.store),d=(0,r.select)(o.store).getBlock(n).innerBlocks;return(0,a.jsx)(l.ToolbarGroup,{children:(0,a.jsxs)(l.ToolbarButton,{icon:s,onClick:()=>{const t=(0,e.createBlock)("cozy-block/toggle-content-item",{});i(t,d.length,n,!1),c(t.clientId)},children:[(0,t.__)("Add Item","cozy-addons")," "]})})})),$=(0,i.memo)((({blockID:e,attributes:t,setAttributes:l,clientId:n,innerBlocks:s})=>{const[c,d]=(0,i.useState)(!1);return(0,a.jsxs)(a.Fragment,{children:["tab"===t.type&&(0,a.jsx)(o.BlockControls,{children:(0,a.jsx)(k,{clientId:n})}),""!=t.tabStyles.font.family&&null!=t.tabStyles.font.family&&(0,a.jsx)("link",{rel:"stylesheet",href:`https://fonts.googleapis.com/css2?family=${t.tabStyles.font.family}:wght@100;200;300;400;500;600;700;800;900`}),""!=t.toggleStyles.font.family&&null!=t.toggleStyles.font.family&&(0,a.jsx)("link",{rel:"stylesheet",href:`https://fonts.googleapis.com/css2?family=${t.toggleStyles.font.family}:wght@100;200;300;400;500;600;700;800;900`}),""!=t.font.family&&null!=t.font.family&&(0,a.jsx)("link",{rel:"stylesheet",href:`https://fonts.googleapis.com/css2?family=${t.font.family}:wght@100;200;300;400;500;600;700;800;900`}),(0,a.jsxs)("div",{id:e,className:"cozy-block-toggle-content"+(t.shadow.enabled?" has-box-shadow":""),children:[(0,a.jsxs)("div",{className:`toggle-content__header content-width-${t.wrapperStyles.width} content-align-${t.wrapperStyles.contentAlign}`,children:["tab"===t.type&&(0,a.jsx)(a.Fragment,{children:(0,a.jsx)("ul",{className:"toggle-content__tabs",children:t.tabs.length>0&&t.tabs.map((e=>{const n=(0,r.select)(o.store).getBlockAttributes(e.clientId);return(0,a.jsx)(a.Fragment,{children:(0,a.jsx)("li",{className:"tab-item"+(t.activeContent===e.clientId?" active-tab":""),onClick:()=>l({...t,activeContent:e.clientId}),children:(0,a.jsx)(o.RichText,{tagName:"p",allowedFormats:[],value:n?.tabLabel,onChange:a=>{(0,r.dispatch)(o.store).updateBlockAttributes(e.clientId,{...n,tabLabel:a});const s=t.tabs.map((t=>t.clientId===e.clientId?{...t,tabLabel:a}:t));l({...t,tabs:[...s]})}})},e.clientId)})}))})}),s&&s.length>=2&&"toggle"===t.type&&(0,a.jsx)(a.Fragment,{children:(0,a.jsxs)("div",{className:"toggle-content__slider",children:[(0,a.jsx)(o.RichText,{tagName:"p",allowedFormats:[],value:s[0].attributes.tabLabel,onChange:e=>{(0,r.dispatch)(o.store).updateBlockAttributes(s[0].clientId,{...s[0].attributes,tabLabel:e});const n=t.tabs.map((t=>t.clientId===s[0].clientId?{...t,tabLabel:e}:t));l({...t,tabs:[...n]})}}),(0,a.jsxs)("label",{class:"switch",children:[(0,a.jsx)("input",{id:"toggle-switch",type:"checkbox",checked:c,onChange:()=>{d(!c),l(c?{...t,activeContent:s[0].clientId}:{...t,activeContent:s[1].clientId})}}),(0,a.jsx)("span",{class:"slider"})]}),(0,a.jsx)(o.RichText,{tagName:"p",allowedFormats:[],value:s[1].attributes.tabLabel,onChange:e=>{(0,r.dispatch)(o.store).updateBlockAttributes(s[1].clientId,{...s[1].attributes,tabLabel:e});const n=t.tabs.map((t=>t.clientId===s[1].clientId?{...t,tabLabel:e}:t));l({...t,tabs:[...n]})}})]})})]}),(0,a.jsx)(f,{})]})]})})),B=JSON.parse('{"UU":"cozy-block/toggle-content","h_":"The toggle content, featuring a switcher or tab-style design, allows users to seamlessly switch between different content sections for a more organized and interactive experience."}'),T=(0,a.jsx)(a.Fragment,{children:(0,a.jsxs)("svg",{width:"27",height:"13",viewBox:"0 0 27 13",fill:"none",xmlns:"http://www.w3.org/2000/svg",children:[(0,a.jsx)("path",{fillRule:"evenodd",clipRule:"evenodd",d:"M20.5 1.5H6.5C3.73858 1.5 1.5 3.73858 1.5 6.5C1.5 9.26142 3.73858 11.5 6.5 11.5H20.5C23.2614 11.5 25.5 9.26142 25.5 6.5C25.5 3.73858 23.2614 1.5 20.5 1.5ZM6.5 0C2.91015 0 0 2.91015 0 6.5C0 10.0899 2.91015 13 6.5 13H20.5C24.0899 13 27 10.0899 27 6.5C27 2.91015 24.0899 0 20.5 0H6.5Z",fill:"#0C50FF"}),(0,a.jsx)("path",{d:"M3 6.5C3 4.29086 4.79086 2.5 7 2.5C9.20914 2.5 11 4.29086 11 6.5C11 8.70914 9.20914 10.5 7 10.5C4.79086 10.5 3 8.70914 3 6.5Z",fill:"#0C50FF"})]})}),I=(0,a.jsx)(a.Fragment,{children:(0,a.jsxs)("svg",{width:"25",height:"20",viewBox:"0 0 25 20",fill:"none",xmlns:"http://www.w3.org/2000/svg",children:[(0,a.jsx)("rect",{fill:"white",x:"0.5",y:"0.5",width:"24",height:"19",rx:"2.5",stroke:"#5566CA"}),(0,a.jsx)("path",{d:"M12.5 5C9.7379 5 7.5 7.2379 7.5 10C7.5 12.7621 9.7379 15 12.5 15C15.2621 15 17.5 12.7621 17.5 10C17.5 7.2379 15.2621 5 12.5 5ZM15.4032 10.5645C15.4032 10.6976 15.2944 10.8065 15.1613 10.8065H13.3065V12.6613C13.3065 12.7944 13.1976 12.9032 13.0645 12.9032H11.9355C11.8024 12.9032 11.6935 12.7944 11.6935 12.6613V10.8065H9.83871C9.70565 10.8065 9.59677 10.6976 9.59677 10.5645V9.43548C9.59677 9.30242 9.70565 9.19355 9.83871 9.19355H11.6935V7.33871C11.6935 7.20565 11.8024 7.09677 11.9355 7.09677H13.0645C13.1976 7.09677 13.3065 7.20565 13.3065 7.33871V9.19355H15.1613C15.2944 9.19355 15.4032 9.30242 15.4032 9.43548V10.5645Z",fill:"#36CFC6"})]})});(0,e.registerBlockType)("cozy-block/toggle-content-item",{title:(0,t.__)("Toggle Content Item","cozy-addons"),textdomain:"cozy-addons",description:(0,t.__)("Helper block for toggle content","cozy-addons"),category:"cozy-block",icon:{src:I},attributes:{clientId:{type:"string",default:""},tabLabel:{type:"string",default:"New Tab"}},usesContext:["activeContent"],parent:["cozy-block/toggle-content"],edit:function({attributes:e,setAttributes:t,clientId:l,context:{activeContent:n}}){e.clientId=l;const s=`cozyBlock_${l.replace(/-/gi,"_")}`;return(0,a.jsx)(a.Fragment,{children:(0,a.jsx)("div",{id:s,className:"cozy-block-toggle-content-item"+(n===l?" show-content":""),children:(0,a.jsx)(o.InnerBlocks,{template:[["core/group"]]})})})},save:function({attributes:e}){const t=`cozyBlock_${e.clientId.replace(/-/gi,"_")}`;return(0,a.jsx)(a.Fragment,{children:(0,a.jsx)("div",{id:t,className:"cozy-block-toggle-content-item",children:(0,a.jsx)(o.InnerBlocks.Content,{})})})}}),(0,e.registerBlockType)(B.UU,{title:(0,t.__)("Toggle Content","cozy-addons"),description:(0,t.__)(B.h_,"cozy-addons"),icon:{src:T},edit:function({attributes:e,setAttributes:t,clientId:l}){if(e.cover)return(0,a.jsx)("img",{src:e.cover});e.clientId=l;const n=`cozyBlock_${l.replace(/-/gi,"_")}`,s=(0,o.useBlockProps)({className:"cozy-block-wrapper"}),c=(0,r.select)(o.store).getBlock(l).innerBlocks;return(0,i.useEffect)((()=>{if(c.length>0){const o=c[0].clientId,l=c.map((e=>({clientId:e.clientId,blockID:`cozyBlock_${e.clientId.replace(/-/gi,"_")}`,tabLabel:e.attributes.tabLabel})));t({...e,activeContent:o,tabs:[...l]})}}),[c]),(0,a.jsxs)(a.Fragment,{children:[(0,a.jsxs)("div",{...s,children:[(0,a.jsx)("style",{dangerouslySetInnerHTML:{__html:C(n,e)}}),(0,a.jsx)($,{clientId:l,blockID:n,attributes:e,setAttributes:t,innerBlocks:c})]}),(0,a.jsx)(w,{attributes:e,setAttributes:t})]})},save:function({attributes:e,clientId:t}){return(0,a.jsx)(o.InnerBlocks.Content,{})}})}},o={};function l(e){var n=o[e];if(void 0!==n)return n.exports;var a=o[e]={exports:{}};return t[e](a,a.exports,l),a.exports}l.m=t,e=[],l.O=(t,o,n,a)=>{if(!o){var s=1/0;for(d=0;d<e.length;d++){for(var[o,n,a]=e[d],r=!0,i=0;i<o.length;i++)(!1&a||s>=a)&&Object.keys(l.O).every((e=>l.O[e](o[i])))?o.splice(i--,1):(r=!1,a<s&&(s=a));if(r){e.splice(d--,1);var c=n();void 0!==c&&(t=c)}}return t}a=a||0;for(var d=e.length;d>0&&e[d-1][2]>a;d--)e[d]=e[d-1];e[d]=[o,n,a]},l.o=(e,t)=>Object.prototype.hasOwnProperty.call(e,t),(()=>{var e={57:0,350:0};l.O.j=t=>0===e[t];var t=(t,o)=>{var n,a,[s,r,i]=o,c=0;if(s.some((t=>0!==e[t]))){for(n in r)l.o(r,n)&&(l.m[n]=r[n]);if(i)var d=i(l)}for(t&&t(o);c<s.length;c++)a=s[c],l.o(e,a)&&e[a]&&e[a][0](),e[a]=0;return l.O(d)},o=globalThis.webpackChunktoggle_content=globalThis.webpackChunktoggle_content||[];o.forEach(t.bind(null,0)),o.push=t.bind(null,o.push.bind(o))})();var n=l.O(void 0,[350],(()=>l(135)));n=l.O(n)})();