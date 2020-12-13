<svelte:head><title>Edit Todo</title></svelte:head>
<script context="module">
    export async function preload({params}){
        const {todo} = params;
        const response = await this.fetch("http://localhost/todo/get.php", {
            method: "POST",
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({id: todo}),
        });
        const item = await response.json();
        if(response.ok){
            return {item};
        }
        this.error(404, 'Not Found')
    }
    async function handleUpdate(){
        const response = await fetch("http://localhost/todo/edit.php", {
            method: "POST",
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({id: id.value, item: item.value})
        })
        if(response.ok){
            alert('Successful')
        }
        else{
            alert("Failed to edit todo")
        }
    }
</script>
<script>
   export let item;
</script>
<div class="row mt-4">
    <div class="col-md-4 offset-md-4 card">
        <div class="card-header bg-white">EDIT TODO</div>
        <div class="card-body">
            <form method="POST" on:submit|preventDefault={handleUpdate}>
                <input type="hidden" id="id" value={item.id} />
                <div class="form-group">
                    <input type="text" id="item" value={item.item} placeholder="Enter Todo Item" class="form-control"/>
                </div>
                <button type="submit" name="submit" class="btn btn-md btn-block btn-warning text-white">Edit</button>
            </form>
        </div>
    </div>
</div>