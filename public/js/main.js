const todos = document.getElementById('todos');

if(todos)
{
    todos.addEventListener('click', (e) => {

       if(e.target.className === "btn btn-danger rounded delete-todo") {
           if(confirm('Are You sure?')) {
               const id = e.target.getAttribute('data-id');

               //delete

               fetch(`/todo/delete/${id}`,{
                   method: 'DELETE'
               }).then(res => console.log(res));
           }
       }
    });
}