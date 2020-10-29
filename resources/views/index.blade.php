@extends('layout')

@section('title', 'Clientes')

@section('content')
	
	<div class="col col-md-10 mx-auto mt-5 px-0">
		<div class="d-flex justify-content-between flex-column flex-sm-row">
			<div class="mb-2 mb-sm-0">
				@role(['atendimento', 'gerencia'])
					<button type="button" data-toggle="modal" data-target="#clientCreateModal" class="btn btn-success">
						<i class="fas fa-user-plus fa-fw mr-1"></i>Novo cliente
					</button>
				@else('design')
					<span class="d-inline-block" tabindex="0" data-toggle="tooltip" title="Você não tem permissão para isso">
						<button style="pointer-events: none;" class="btn btn-success" disabled="disabled">
							<i class="fas fa-user-plus fa-fw mr-1"></i>Novo cliente
						</button>
					</span>
				@endrole
			</div>

			<div>
				<form method="GET" action="{{ route('clients.index') }}">
					<div class="form-group">
						<div class="input-group">
							<input class="form-control" name="nome" type="text" placeholder="Por nome...">
							<div class="input-group-append">
								<button class="btn btn-outline-primary">Buscar</button>
							</div>
						</div>
					</div>
				</form>	
			</div>
		</div>

		<div class="card mt-2">
			<div class="card-header bg-primary font-weight-bold text-white">
				<i class="fas fa-list fa-fw mr-1"></i> Lista de clientes
			</div>

			<div class="card-body px-0">
				<div class="table-responsive">
					<table class="table table-hover">
						<thead>
							<tr>
								<th>Nome</th>
								<th>Telefone</th>
								<th>Cidade</th>
							</tr>
						</thead>

						<tbody>
							@foreach($clients as $client)
								<tr class="clickable-link" data-url="{{ $client->path() }}">
									<td>{{ $client->name }}</td>
									<td nowrap="nowrap">{{ $client->phone ? Mask::phone($client->phone) : '[não informado]' }}</td>
									<td nowrap="nowrap">{{ $client->city ?? '[não informado]' }}</td>
								</tr>
							@endforeach
						</tbody>	
					</table>
				</div>	

			</div>
		</div>
		
		<div class="mt-2">
			{{ $clients->links() }}
		</div>
	</div>

	@role(['gerencia', 'atendimento'])
		@include('clients.create-modal')
	@endrole
@endsection