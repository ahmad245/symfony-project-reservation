

    let btn=document.getElementById('add-image');

  
    

    btn.addEventListener('click',handelClick);



  function handel(){
      let btnDelete=document.querySelectorAll('button[data-action="delete"]');
      let btnArray=Array.from(btnDelete);
       btnArray.map(el=>{
         el.addEventListener('click',function(){
            let data=this.dataset.target;
              document.querySelector(data).remove();
         })
       })
  }
  function handelClick(){
    let images=document.getElementById('ad_images')
    let index=+document.getElementById('counter').value;
   let data=images.dataset.prototype.replace(/__name__/g,index);

       // console.log(data);
       console.log(data);
       console.log('asdfasfdsfasdfasdfasdf');
  
   images.insertAdjacentHTML('beforeend',data);
   document.getElementById('counter').value=index+1
   handel();
 
  }
