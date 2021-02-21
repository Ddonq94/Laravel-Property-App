@extends ('layouts.layout')

@section ('content')

<h1>Hii, see your Properties below</h1>
<p><small class="text-primary"> Only Load from API once</small></p>

<div class="container mt-4">

@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
  @endif

</div>



<a href="/properties/create" class="btn btn-primary  mb-4"> Add New</a>
<a href="/properties/getFromAPI" class="btn btn-warning  mb-4"> Load From API (<small>This will take a while </small>)</a>

<div style="margin-bottom:15px">
<form  method="get" action="{{url('properties')}}" class="row">
                    @csrf

    <select name="num_bedrooms" class="custom-select col-2" >
        <option selected value=''>Number of Bedrooms</option>
        
        <option value="1">1</option>
        <option value="2">2</option>
        <option value="3">3</option>
        <option value="4">4</option>
    </select>
    <input type="number" id="price" placeholder="Price" name="price" class="form-control col-2" >
    <select name="property_type_id" class="custom-select col-2" >
                <option selected value=''>Property Type</option>
                
                <option value="1">Flat</option>
                <option value="2">Detatched</option>
                <option value="3">Semi-detached</option>
                <option value="4">Terraced</option>
            </select>


<span class="col-3">
            <input type="radio"  name="type" value="sale"  >Sale <br>
          <input type="radio"  name="type" value="rent" >Rent
</span>

     <button type="submit" class=" col-2 btn btn-sm btn-danger float-right ml-2">Search</button>
                </form>
</div>


@if($properties->count())
    @foreach ($properties as $prop )
        <div class="row" style="border:1px #fafafa solid; padding:10px; margin-bottom: 30px">
            
            <div class="col-9 row">
                <div class="col-2"> <b>County:</b> <br/> {{ $prop->county }}</div>
                <div class="col-2"><b>Country:</b> <br/> {{ $prop->country }}</div>
                <div class="col-2"><b>Town:</b><br/> {{ $prop->town }}</div>
                <div class="col-2"><b>Bedrooms:</b><br/> {{ $prop->num_bedrooms }}</div>
                <div class="col-2"><b>Bathrooms:</b> <br/>{{ $prop->num_bathrooms }}</div>
                <div class="col-2"><b>Type:</b><br/> {{ $prop->type }}</div>
                <div class="col-6"><b>Description:</b> <br/>{{ $prop->description }}</div>
                <div class="col-6"><b>Address:</b> <br/> {{ $prop->address }}</div>
            </div>
            <div class="col-3">
                <form  method="post" action="{{url('properties')}}/{{$prop->id}}">
                    @csrf
                    <input name="_method" type="hidden" value="DELETE">
                        <button type="submit" class="btn btn-sm btn-danger float-right ml-2">Delete</button>
                </form>
  
                <a class="btn btn-sm btn-secondary float-right" href="/properties/{{$prop->id}}/edit">Edit</a> 
            </div>
        </div> 
    @endforeach
    <div class="d-flex justify-content-center">
        {{$properties->links()}}
    </div>
@else
<div class="card">
    <div class="card-body text-danger">
        Maybe add some Properties first? 
    </div>
</div>
@endif







@endsection