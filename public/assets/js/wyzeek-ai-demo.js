/* WYZEEK — fully local scripted AI concept demo. Never sends network requests. */
(function(){
 'use strict';
 function start(){
  const byId=id=>document.getElementById(id);
  const dialog=byId('wyz-ai-dialog'),shade=byId('wyz-ai-shade'),launcher=byId('wyz-ai-launcher');
  const closeButton=byId('wyz-ai-close'),feed=byId('wyz-ai-feed'),options=byId('wyz-ai-options');
  const input=byId('wyz-ai-input'),form=byId('wyz-ai-form'),sample=byId('wyz-ai-sample'),exampleButton=byId('wyz-ai-example');
  if(!dialog||!shade||!launcher||!closeButton||!feed||!form)return;
  let task=null,token=0,pending=false,lastFocus=null;
  const SAMPLE={
   result:'Student 1201 Bengali 100 English 50 Mathematics 50',
   attendance:'Class 8 Present 1201, 1202 Absent 1203',
   notice:'Exam notice: Mathematics exam is scheduled for Sunday at 10:00 AM.'
  };
  function scroll(){feed.scrollTop=feed.scrollHeight;}
  function message(text,kind){const wrap=document.createElement('div');wrap.className='wyz-ai-msg '+(kind==='user'?'wyz-ai-msg-user':'wyz-ai-msg-bot');const bubble=document.createElement('span');bubble.className='wyz-ai-bubble';bubble.textContent=text;wrap.appendChild(bubble);feed.appendChild(wrap);scroll();return wrap;}
  function typing(){const wrap=document.createElement('div');wrap.className='wyz-ai-msg wyz-ai-msg-bot';const bubble=document.createElement('span');bubble.className='wyz-ai-bubble wyz-ai-typing';for(let i=0;i<3;i++)bubble.appendChild(document.createElement('span'));wrap.appendChild(bubble);feed.appendChild(wrap);scroll();return wrap;}
  function reply(text,after){const ownToken=++token;pending=true;const dots=typing();const delay=window.matchMedia('(prefers-reduced-motion:reduce)').matches?40:520;window.setTimeout(()=>{dots.remove();if(ownToken!==token)return;pending=false;message(text,'bot');if(after)after();},delay);}
  function open(){lastFocus=document.activeElement;dialog.hidden=false;shade.hidden=false;launcher.setAttribute('aria-expanded','true');input.focus();scroll();}
  function close(){token++;pending=false;dialog.hidden=true;shade.hidden=true;launcher.setAttribute('aria-expanded','false');if(lastFocus&&lastFocus.focus)lastFocus.focus();}
  launcher.addEventListener('click',()=>dialog.hidden?open():close());closeButton.addEventListener('click',close);shade.addEventListener('click',close);
  document.addEventListener('keydown',event=>{
   if(dialog.hidden)return;
   if(event.key==='Escape'){close();return;}
   if(event.key==='Tab'){
    const focusable=Array.from(dialog.querySelectorAll('button:not([disabled]):not([hidden]),textarea:not([disabled]),a[href]')).filter(el=>el.getClientRects().length);
    if(!focusable.length)return;
    if(event.shiftKey&&document.activeElement===focusable[0]){event.preventDefault();focusable[focusable.length-1].focus();}
    else if(!event.shiftKey&&document.activeElement===focusable[focusable.length-1]){event.preventDefault();focusable[0].focus();}
   }
  });
  function choose(type){
   token++;pending=false;task=type;sample.hidden=(type==='help');
   options.querySelectorAll('button').forEach(button=>button.setAttribute('aria-pressed',String(button.dataset.wyzDemo===type)));
   const instructions={
    result:'Result Update · Concept preview\nType the student ID and subject marks in your own order, e.g. “Student 1201 Bengali 100 English 50 Mathematics 50”. I will arrange a marks table and request confirmation. (Supported demo subjects: Bengali, English, Mathematics.)',
    attendance:'Attendance Update · Concept preview\nType a class and student IDs, e.g. “Class 8 Present 1201,1202 Absent 1203”. I will create a review table before a simulated confirmation.',
    notice:'Notice Preparation · Concept preview\nWrite a notice in natural language. I will format a notice preview and ask you to confirm; it will NOT be published.',
    help:'How it will work after approval:\n1. Teacher selects a workflow.\n2. Teacher types or speaks in Bangla/English.\n3. AI extracts fields and checks permissions/validations.\n4. Teacher reviews a table and confirms.\n5. Backend saves ONLY after approval.\n\nToday steps 2–5 are visual mockups and save is disabled.'
   };
   input.placeholder=type==='help'?'Choose another workflow…':(type==='result'?'Student 1201 Bengali 100…':type==='attendance'?'Class 8 Present 1201…':'Write your notice…');
   message(type==='result'?'Update Result':type==='attendance'?'Update Attendance':type==='notice'?'Prepare Notice':'How It Works','user');
   reply(instructions[type],()=>{if(type!=='help')input.focus();});
  }
  options.addEventListener('click',event=>{const button=event.target.closest('button[data-wyz-demo]');if(button)choose(button.dataset.wyzDemo);});
  exampleButton.addEventListener('click',()=>{if(!SAMPLE[task])return;input.value=SAMPLE[task];input.focus();});
  const toAscii=text=>String(text).replace(/[০-৯]/g,ch=>String('০১২৩৪৫৬৭৮৯'.indexOf(ch)));
  function marks(raw){
   const t=toAscii(raw);const id=t.match(/(?:student(?:\s*(?:id|#))?\s*[:#-]?\s*(\d{3,8}))|(\d{3,8})\s*নম্বর\s*শিক্ষার্থী|শিক্ষার্থী\s*(\d{3,8})/i);
   if(!id)return {error:'Please include a Student ID, for example “Student 1201”.'};
   const spec=[['Bengali',/(?:bengali|বাংলা(?:য়|য়|তে)?)\s*[:=\-]?\s*(\d{1,3})/i],['English',/(?:english|ইংরেজি(?:তে|য়|য়)?)\s*[:=\-]?\s*(\d{1,3})/i],['Mathematics',/(?:mathematics|math|গণিত(?:ে|তে)?)\s*[:=\-]?\s*(\d{1,3})/i]];
   const rows=[];for(const [label,regex] of spec){const match=t.match(regex);if(!match)continue;const score=Number(match[1]);if(score<0||score>100)return {error:'Marks must be between 0 and 100.'};rows.push([label,String(score)]);}
   if(!rows.length)return {error:'No supported subject marks found. Example: Student 1201 Bengali 100 English 50 Mathematics 50.'};
   return {title:'Result Panel — Preview',detail:'Student ID: '+(id[1]||id[2]||id[3])+' · Sample grading scale: 0–100',heads:['Subject','Marks'],rows};
  }
  function attendance(raw){
   const t=toAscii(raw);const classId=t.match(/(?:class|শ্রেণি)\s*[:#-]?\s*(\d{1,3})/i);
   const pre=t.match(/(?:present|উপস্থিত)\s*[:=\-]?\s*([\d,\s]+)/i);
   const abs=t.match(/(?:absent|অনুপস্থিত)\s*[:=\-]?\s*([\d,\s]+)/i);
   if(!classId||(!pre&&!abs))return {error:'Use “Class 8 Present 1201,1202 Absent 1203”. This demo recognizes student IDs, not names.'};
   const pick=m=>m?(m[1].match(/\d{3,8}/g)||[]):[];
   const p=pick(pre),a=pick(abs);
   if(!p.length&&!a.length)return {error:'Enter at least one Student ID for attendance.'};
   const intersection=p.filter(id=>a.includes(id));if(intersection.length)return {error:'A student cannot be both Present and Absent: '+intersection.join(', ')};
   const rows=[...p.map(id=>[id,'Present']),...a.map(id=>[id,'Absent'])];
   return {title:'Attendance Register — Preview',detail:'Class '+classId[1]+' · Demo entries only',heads:['Student ID','Status'],rows};
  }
  function notice(raw){
   const text=raw.trim();if(text.length<8)return {error:'Please write a notice of at least 8 characters.'};
   return {title:'Notice Draft — Preview',detail:'Unpublished notice · Demo',heads:['Field','Value'],rows:[['Title','School Notice'],['Text',text.slice(0,280)],['Status','Draft (demo)']]};
  }
  function createPreview(data){
   const card=document.createElement('section');card.className='wyz-ai-table-card';
   const h=document.createElement('h3');h.textContent=data.title;card.appendChild(h);
   const p=document.createElement('p');p.textContent=data.detail;card.appendChild(p);
   const scroller=document.createElement('div');scroller.className='wyz-ai-table-scroll';const table=document.createElement('table');table.className='wyz-ai-table';
   const thead=document.createElement('thead'),tr=document.createElement('tr');data.heads.forEach(label=>{const th=document.createElement('th');th.textContent=label;tr.appendChild(th);});thead.appendChild(tr);table.appendChild(thead);
   const tbody=document.createElement('tbody');data.rows.forEach(row=>{const tr=document.createElement('tr');row.forEach(value=>{const td=document.createElement('td');td.textContent=String(value);tr.appendChild(td);});tbody.appendChild(tr);});table.appendChild(tbody);scroller.appendChild(table);card.appendChild(scroller);
   const tag=document.createElement('span');tag.className='wyz-ai-preview-tag';tag.textContent='Visual preview only · No records fetched';card.appendChild(tag);
   const confirm=document.createElement('button');confirm.type='button';confirm.className='wyz-ai-confirm-btn';confirm.textContent='✓ Confirm (Simulation)';card.appendChild(confirm);
   confirm.addEventListener('click',()=>{confirm.disabled=true;confirm.textContent='Demo confirmed';message('Confirm (simulation)','user');reply('✅ Demonstration complete. A real system would now validate permissions and save the reviewed records. This prototype has NOT saved or changed any student, result, attendance or notice data.');});
   feed.appendChild(card);scroll();
  }
  form.addEventListener('submit',event=>{
   event.preventDefault();if(pending)return;
   const raw=input.value.trim();if(!raw)return;
   message(raw,'user');input.value='';
   if(!task||task==='help'){reply('Choose Update Result, Update Attendance, or Prepare Notice first.');return;}
   const data=task==='result'?marks(raw):task==='attendance'?attendance(raw):notice(raw);
   if(data.error){reply(data.error);return;}
   reply('I arranged the information below. Please review each value carefully before confirming the demo.',()=>createPreview(data));
  });
  input.addEventListener('keydown',event=>{if(event.key==='Enter'&&!event.shiftKey){event.preventDefault();form.requestSubmit();}});
  // Add an AI entry to module navigation without exposing new backend routes/permissions.
  function addSidebarLink(){
   const menu=document.querySelector('#aside [data-wyzeek-module-menu]');if(!menu||menu.querySelector('[data-wyz-module="ai"]'))return;
   const li=document.createElement('li');li.className='wyz-module-container';li.dataset.wyzModule='ai';
   const details=document.createElement('details');details.className='wyz-module-group';details.open=true;
   const summary=document.createElement('summary');summary.className='wyz-module-header';summary.textContent='AI Chatbot · Demo';
   const ul=document.createElement('ul');ul.className='wyz-module-items';
   const inner=document.createElement('li');const button=document.createElement('button');button.type='button';button.className='wyz-demo-menu-btn';button.textContent='✦ Open animated assistant';button.addEventListener('click',()=>{open();});inner.appendChild(button);ul.appendChild(inner);details.append(summary,ul);li.appendChild(details);
   const account=menu.querySelector('[data-wyz-module="account"]');if(account)menu.insertBefore(li,account);else menu.appendChild(li);
  }
  addSidebarLink();document.addEventListener('wyzeek:modules-ready',addSidebarLink);
  document.dispatchEvent(new CustomEvent('wyzeek:ai-ready'));
 }
 if(document.readyState==='loading')document.addEventListener('DOMContentLoaded',start,{once:true});else start();
})();
