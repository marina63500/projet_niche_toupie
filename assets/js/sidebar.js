
   const sidebarBtn = document.getElementById('sidebarBtn');
   const sidebar = document.getElementById('sidebar');
   const content = document.getElementById('content');


   if(sidebarBtn !== null && sidebar !== null && content !== null) {

   sidebarBtn.addEventListener('click', () => {
      sidebar.classList.toggle('active');
      content.classList.toggle('shift');
    });
  }

