<svelte:head><title>All Todos</title></svelte:head>
<script>
    async function getData(){
    const response = await fetch('http://localhost/todo/all.php');
    const data = await response.json();
        return data;
    };

    async function deleteTodo(id){
        const res = await fetch('https://localhost/todo/delete.php', {
            method: "POST",
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({id: id})
        });
        if(res.ok){
            alert("Todo deleted successfully");
        }
        else{
            alert("Unable to delete todo");
        }
    };
    async function markTodo(status,id){
        const newStatus = status === "0" ? "1" : "0";
        const res = await fetch('https://localhost/todo/mark.php', {
            method: "POST",
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({id: id, status: newStatus})
        });
        if(res.ok){
            alert("Todo updated successfully");
        }
        else{
            alert("Unable to update todo");
        }
    };
</script>
<div class="row mt-4">
    <div class="col-md-4 offset-md-4 card">
        <div class="card-header bg-white">MY TODOS</div>
        <div class="card-body">
            <ul class="list-group">
                {#await getData()}
                    <li class="list-group-item">Fetching todos</li>
                {:then items}
                {#each items as todo (todo.id)}
                    <li class="list-group-item">
                        {todo.item}
                        <span class="float-right">
                            <a href="todo" on:click|preventDefault="{() => markTodo(todo.status, todo.id)}">
                                {#if todo.status == 0}
                                    <span class="btn btn-sm btn-success p-1 text-white"><small>MARK AS COMPLETE</small></span>
                                {:else}
                                    <span class="btn btn-sm btn-warning p-1 text-white"><small>UNMARK</small></span>
                                {/if}
                            </a>
                            <a href="todo/edit/{todo.id}"><i class="fa fa-edit text-info mx-2"></i></a>
                            <a href="todo" on:click|preventDefault="{() => deleteTodo(todo.id) }"><i class="fa fa-trash text-danger mx-2"></i></a>
                        </span>
                    </li>
                {/each}
                {:catch error}
                    <li class="list-group-item">Unable to fetch todo</li>
                {/await}
            </ul>
        </div>
    </div>
</div>