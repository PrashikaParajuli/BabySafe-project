function set_role(role,btn){
            document.getElementById('role').value = role;

         document.querySelectorAll('.role-btn').forEach(button =>
         {
            button.classList.remove('active');
        });

        btn.classList.add('active');

        console.log =  (document.getElementById('role').value);
    }