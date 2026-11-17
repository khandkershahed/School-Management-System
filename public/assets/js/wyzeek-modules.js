/* WYZEEK sidebar grouping: presentation-only, reuses original authorized nav items. */
(function(){
 'use strict';
 const MODULES=[
  ['admission','Admission and Registration'],
  ['attendance','Attendance'],
  ['exams','Exam and Result'],
  ['fees','Fees and Accounts'],
  ['administration','Administration'],
  ['rbac','RBAC (Roles and Permissions)'],
  ['notice','Notice upload / Discussions'],
  ['ai','AI Chatbot (Demo)']
 ];
 function pathOf(link){
  try{return new URL(link.getAttribute('href'),window.location.href).pathname.toLowerCase().replace(/\/+$/,'')||'/';}
  catch(_e){return '';}
 }
 function category(node){
  const links=Array.from(node.querySelectorAll('a[href]')).map(pathOf).filter(Boolean);
  const paths=links.join(' ');
  if(/\/user\/profile|\/profile/.test(paths))return 'profile';
  if(/\/users\/add|\/register|\/roles(?:\s|$)|\/user-role/.test(paths))return 'rbac';
  if(/\/parent\/children\/attendances|\/attendance/.test(paths))return 'attendance';
  if(/\/parent\/children\/(?:invoices|receipts)|\/fee|\/receipt|\/payment/.test(paths))return 'fees';
  if(/\/exam|\/subjects|\/student\/subjects/.test(paths))return 'exams';
  if(/\/discussions|\/discussion/.test(paths))return 'notice';
  if(/\/student|\/parent\/children$/.test(paths))return 'admission';
  if(/\/teacher|\/parents|\/academic_year|\/grade|\/classroom|\/auditlogs|\/meeting/.test(paths))return 'administration';
  return 'administration';
 }
 function group(){
  const aside=document.getElementById('aside');if(!aside)return;
  const menu=aside.querySelector('div.items-center > ul');if(!menu||menu.dataset.wyzGrouped)return;
  const original=Array.from(menu.children).filter(e=>e.tagName==='LI');
  if(original.length<2)return;
  menu.dataset.wyzGrouped='true';menu.setAttribute('data-wyzeek-module-menu','true');
  const brandline=document.createElement('span');brandline.className='wyz-sidebar-brandline';brandline.textContent='WYZEEK · PAPERLESS PLATFORM';
  const header=aside.querySelector('div.h-19\\.5,div[class*="h-19"]');if(header)header.insertAdjacentElement('afterend',brandline);
  const dashboard=original.shift();dashboard.classList.add('wyz-module-direct');
  menu.appendChild(dashboard);
  const groups=new Map();
  MODULES.forEach(([key,title])=>{
   if(key==='ai')return;
   const li=document.createElement('li');li.className='wyz-module-container';li.dataset.wyzModule=key;
   const detail=document.createElement('details');detail.className='wyz-module-group';
   const summary=document.createElement('summary');summary.className='wyz-module-header';summary.textContent=title;
   const list=document.createElement('ul');list.className='wyz-module-items';
   detail.append(summary,list);li.append(detail);menu.appendChild(li);groups.set(key,{li,detail,list});
  });
  const footer=document.createElement('li');footer.className='wyz-module-container';footer.dataset.wyzModule='account';
  const account=document.createElement('details');account.className='wyz-module-group';
  const label=document.createElement('summary');label.className='wyz-module-header';label.textContent='My Account';
  const accountList=document.createElement('ul');accountList.className='wyz-module-items';account.append(label,accountList);footer.appendChild(account);menu.appendChild(footer);
  const current=window.location.pathname.toLowerCase().replace(/\/+$/,'')||'/';
  original.forEach(node=>{
   const key=category(node);const destination=key==='profile'?accountList:groups.get(key).list;
   destination.appendChild(node);
   const links=Array.from(node.querySelectorAll('a[href]'));
   if(links.some(link=>pathOf(link)===current)){
    const details=destination.closest('details');if(details)details.open=true;
    // Preserve the existing route-accordion state; only reveal the active branch.
    const match=links.find(link=>pathOf(link)===current);
    if(match){const submenu=match.closest('ul[id]');if(submenu && submenu!==destination)submenu.classList.remove('hidden');}
   }
  });
  for(const [key,{li,list}]of groups){if(!list.children.length){li.hidden=true;}}
  if(!accountList.children.length)footer.hidden=true;
  if(!aside.querySelector('.wyz-module-group[open]')){
   const first=Array.from(groups.values()).find(g=>g.list.children.length);if(first)first.detail.open=true;
  }
  document.dispatchEvent(new CustomEvent('wyzeek:modules-ready'));
 }
 if(document.readyState==='loading')document.addEventListener('DOMContentLoaded',group,{once:true});else group();
})();
