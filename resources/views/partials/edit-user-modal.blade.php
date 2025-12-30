<div class="modal fade" id="editUserModal" tabindex="-1" aria-labelledby="editUserModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="editUserModalLabel">Edit User</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<form id="editUserForm">
					<input type="hidden" id="editUserId" name="id">
					<div class="mb-3">
						<label for="editUserName" class="form-label">Name</label>
						<input type="text" class="form-control" id="editUserName" name="name">
					</div>
					<div class="mb-3">
						<label for="editUserEmail" class="form-label">Email</label>
						<input type="email" class="form-control" id="editUserEmail" name="email">
					</div>
				</form>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
				<button type="button" id="updateUserBtn" class="btn btn-primary">Update</button>
			</div>
		</div>
	</div>
</div>

