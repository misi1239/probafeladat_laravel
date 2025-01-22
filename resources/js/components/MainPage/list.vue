<template>
    <section class="vh-100 gradient-custom-2">
        <div class="container py-5 h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-md-12 col-xl-10">

                    <div class="card mask-custom">
                        <div class="card-body p-4 text-white">

                            <div class="text-center pt-3 pb-2">
                                <h2 class="my-4">Track Time For Projects</h2>
                            </div>

                            <table class="table table-hover text-white mb-0">
                                <thead>
                                <tr>
                                    <td colspan="2">
                                        <div class="input-group">
                                            <input type="text" class="form-control" placeholder="Add new Project" aria-label="add-new-project" aria-describedby="basic-addon1">
                                            <button class="btn btn-success" type="button" id="basic-addon1">Add</button>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="col">Project Name</th>
                                    <th scope="col">Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr class="fw-normal">
                                    <td class="align-middle">
                                        <span>Call Sam For payments</span>
                                    </td>
                                    <td class="align-middle">
                                        <a href="#!" data-bs-toggle="tooltip" title="Remove"><i class="fas fa-trash-alt fa-lg text-danger"></i></a>
                                    </td>
                                </tr>
                                <tr class="fw-normal">
                                    <td class="align-middle">
                                        <span>Call Sam For payments</span>
                                    </td>
                                    <td class="align-middle">
                                        <a href="#!" data-bs-toggle="tooltip" title="Remove"><i class="fas fa-trash-alt fa-lg text-danger"></i></a>
                                    </td>
                                </tr>
                                <!-- Add more rows here -->
                                </tbody>
                            </table>

                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>
</template>

<style scoped lang="scss">
    @use "../../../sass/MainPage/list.scss" as *;
</style>
