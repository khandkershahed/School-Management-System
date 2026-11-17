/* Uses only anchors which Laravel has already exposed to the logged-in role. */
(function(){
 'use strict';
 function ready(){
  const bar=document.getElementById('wyz-mobile-nav'),aside=document.getElementById('aside');
  const overlay=document.getElementById('wyz-mobile-overlay');const more=document.getElementById('wyz-mobile-more');
  if(!bar||!aside||!overlay||!more)return;
  const tab=name=>bar.querySelector('[data-wyz-tab="'+name+'"]');
  const links=Array.from(aside.querySelectorAll('a[href]')).filter(a=>{
   const raw=a.getAttribute('href');if(!raw||raw==='#'||raw.startsWith('javascript:'))return false;
   try{return new URL(raw,window.location.href).origin===window.location.origin;}catch(_){return false;}
  });
  function path(a){try{return new URL(a.href,window.location.href).pathname.toLowerCase().replace(/\/+$/,'');}catch(_){return '';}}
  function select(regex){return links.find(a=>regex.test(path(a)));}
  const primary=select(/\/(?:students|parent\/children|teacher\/classrooms|student\/subjects)$/);
  const attendance=select(/\/(?:attendances|parent\/children\/attendances)$/);
  const fees=select(/\/(?:fees|parent\/children\/invoices|parent\/children\/receipts)$/);
  function setup(name,target,label){
   const el=tab(name);if(!el||!target)return;el.href=target.href;el.hidden=false;
   if(label)el.querySelector('small').textContent=label;
  }
  if(primary){
   const primaryPath=path(primary);
   const label=/teacher\/classrooms/.test(primaryPath)?'Classes':/student\/subjects/.test(primaryPath)?'Learning':/parent\/children/.test(primaryPath)?'Children':'Admissions';
   setup('primary',primary,label);
  }
  setup('attendance',attendance);
  setup('fees',fees);
  function active(){
   const current=window.location.pathname.toLowerCase().replace(/\/+$/,'');
   bar.querySelectorAll('a[href]').forEach(a=>{
    if(!a.hidden && path(a)===current)a.setAttribute('aria-current','page');
    else a.removeAttribute('aria-current');
   });
  }
  active();
  function close(){document.body.classList.remove('wyz-drawer-open');overlay.hidden=true;more.setAttribute('aria-expanded','false');more.focus({preventScroll:true});}
  function open(){document.body.classList.add('wyz-drawer-open');overlay.hidden=false;more.setAttribute('aria-expanded','true');const first=aside.querySelector('a[href]');if(first)first.focus({preventScroll:true});}
  more.addEventListener('click',()=>document.body.classList.contains('wyz-drawer-open')?close():open());
  document.addEventListener('wyzeek:close-mobile-drawer',()=>{
    if(document.body.classList.contains('wyz-drawer-open'))close();
  });
  aside.addEventListener('click',event=>{
    if(window.innerWidth>=768 || !document.body.classList.contains('wyz-drawer-open'))return;
    if(event.target.closest('[data-wyz-close-sidebar]')){close();return;}
    const link=event.target.closest('a[href]');
    if(link && link.getAttribute('href')!=='#' && !link.hasAttribute('data-wyz-open-ai'))close();
  });
  overlay.addEventListener('click',close);
  document.addEventListener('keydown',event=>{if(event.key==='Escape'&&document.body.classList.contains('wyz-drawer-open'))close();});
  window.addEventListener('resize',()=>{if(window.innerWidth>767&&document.body.classList.contains('wyz-drawer-open'))close();});
  const ai=tab('ai');
  document.addEventListener('wyzeek:ai-ready',()=>{
   if(!ai)return;
   ai.hidden=false;
   const fee=tab('fees');if(fee)fee.hidden=true;

   ai.addEventListener('click',()=>document.dispatchEvent(new CustomEvent('wyzeek:open-ai')));
  });
 }
 if(document.readyState==='loading')document.addEventListener('DOMContentLoaded',ready,{once:true});else ready();
})();
