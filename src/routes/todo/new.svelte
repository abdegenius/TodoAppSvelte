<svelte:head><title>New Todo</title></svelte:head>
<script>
async function handleSubmit() {
    const response = await fetch("http://localhost/todo/add.php", {
    method: 'POST',
    headers: {
        'Accept': 'application/json',
        'Content-Type': 'application/json'
    },
    body: JSON.stringify({item: item.value})
    });
    const data = await response.json();
    item.value = "";
    if(data.response == true){
        alert("Todo added successfully");
    }
    if(data.response == false){
        alert("Unable to add todo");
    }
}
</script>
<div class="row mt-4">
    <div class="col-md-4 offset-md-4 card">
        <div class="card-header bg-white">ADD NEW TODO</div>
        <div class="card-body">
            <form method="POST" on:submit|preventDefault="{handleSubmit}">
                <div class="form-group">
                    <input type="text" id="item" placeholder="Enter Todo Item" class="form-control"/>
                </div>
                <button type="submit" name="submit" class="btn btn-md btn-block btn-warning text-white">Add</button>
            </form>
        </div>
    </div>
</div>