
const allSections = document.querySelector('.main-content');
const sections = document.querySelectorAll('.section');
const sectBtns = document.querySelectorAll('.controls');
const sectBtn = document.querySelectorAll('.control');


function PageTransitions(){
    // Change active button to the clicked button
    for(let i = 0; i < sectBtn.length; i++){
        sectBtn[i].addEventListener('click', function(){
            let currentBtn = document.querySelectorAll('.active-btn');
            currentBtn[0].className = currentBtn[0].className.replace('active-btn', '');
            this.className += ' active-btn';         
        })
    }

    // Active class sections
    allSections.addEventListener('click', (e) =>{
        const id = e.target.dataset.id;
        //Removes selected from the other buttons
        if(id){
            sectBtns.forEach((btn) =>{
                btn.classList.remove('active')
            })
            e.target.classList.add('active')

            //Hide other sections
            sections.forEach((section) =>{
                section.classList.remove('active')
            })

            // Gets the id of the dataset under main/section
            const element = document.getElementById(id);
            element.classList.add('active');
        }
    })

    //Toggle light/dark mode
    const themeBtn = document.querySelector('.theme-btn');
    themeBtn.addEventListener('click',() =>{
        let element = document.body;
        element.classList.toggle('light-mode')
    })
}

PageTransitions();
