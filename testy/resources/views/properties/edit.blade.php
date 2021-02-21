@extends ('layouts.layout')

@section ('content')

<h1>Edit Property below</h1>

<div><small class="text-danger">All fields are required except image</small></div>
<small class="text-danger">Leave image blank to use old one</small>



<div class="container mt-4">
 
 
  @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

  <div class="card">
    
    <div class="card-body">
      <form name="edit-prop" id="edit-prop" method="post" action="{{url('properties')}}/{{$property->id}}"  enctype="multipart/form-data">
       @csrf
       <input name="_method" type="hidden" value="PUT">
        <div class="form-group">
          <label > County</label>
          <input type="text" id="county" name="county" value="{{$property->county}}" class="form-control" required>
        </div>
        <div class="form-group">
          <label > Country</label>
          <input type="text" id="country" name="country" value="{{$property->country}}" class="form-control" required>
        </div>
        <div class="form-group">
          <label > Town</label>
          <input type="text" id="town" name="town" value="{{$property->town}}" class="form-control" required>
        </div>
        <div class="form-group">
          <label > Description</label>
          <textarea id="description" name="description"  class="form-control" required>{{$property->description}}</textarea>
        </div>
        <div class="form-group">
          <label > Dislayable Address</label>
          <input type="text" id="address" name="address" value="{{$property->address}}" class="form-control" required>
        </div>
        
        <div class="form-group">
            <label>Select Image <small class="text-danger">Leave image blank to use old one</small></label>
            <input type="file" name="image_full" accept="image/*" class="form-control" id="image_full" >
        </div>

        <!--  -->

        <div class="form-group">
            <select name="num_bedrooms" class="custom-select" required>
                <option  value=''>Number of Bedrooms</option>
                
                <option {{ $property->num_bedrooms == '1' ? 'selected' : '' }} value="1">1</option>
                <option {{ $property->num_bedrooms == '2' ? 'selected' : '' }} value="2">2</option>
                <option {{ $property->num_bedrooms == '3' ? 'selected' : '' }} value="3">3</option>
                <option {{ $property->num_bedrooms == '4' ? 'selected' : '' }} value="4">4</option>
            </select>
        </div>
        
        <div class="form-group">
            <select name="num_bathrooms" class="custom-select" required>
                <option  value=''>Number of Bathrooms</option>
                
                <option {{ $property->num_bathrooms == '1' ? 'selected' : '' }} value="1">1</option>
                <option {{ $property->num_bathrooms == '2' ? 'selected' : '' }} value="2">2</option>
                <option {{ $property->num_bathrooms == '3' ? 'selected' : '' }} value="3">3</option>
                <option {{ $property->num_bathrooms == '4' ? 'selected' : '' }} value="4">4</option>
            </select>
        </div>

        <div class="form-group">
          <label >  Price</label>
          <input type="number" id="price" name="price" value="{{$property->price}}" class="form-control" required>
        </div>

        <div class="form-group">
            <select name="property_type_id" class="custom-select" required>
                <option  value=''>Property Type</option>
                
                <option {{ $property->property_type_id == '1' ? 'selected' : '' }} value="1">Flat</option>
                <option {{ $property->property_type_id == '2' ? 'selected' : '' }} value="2">Detatched</option>
                <option {{ $property->property_type_id == '3' ? 'selected' : '' }} value="3">Semi-detached</option>
                <option {{ $property->property_type_id == '4' ? 'selected' : '' }} value="4">Terraced</option>
            </select>
        </div>

        <div class="form-group">
        <label>  Type</label>

          <input type="radio" {{ $property->type == 'sale' ? 'checked' : '' }}  name="type" value="sale" required >Sale
          <input type="radio" {{ $property->type == 'rent' ? 'checked' : '' }} name="type" value="rent" >Rent
        </div>

        <button type="submit" class="btn btn-primary">Submit</button>
      </form>
    </div>
  </div>
</div>    

@endsection