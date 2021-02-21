@extends ('layouts.layout')

@section ('content')

<h1>Add a Property below</h1>
<small class="text-danger">All fields are required</small>


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
      <form name="add-prop" id="add-prop" method="post" action="{{url('properties')}}"  enctype="multipart/form-data">
       @csrf
        <div class="form-group">
          <label > County</label>
          <input type="text" id="county" name="county" class="form-control" required>
        </div>
        <div class="form-group">
          <label > Country</label>
          <input type="text" id="country" name="country" class="form-control" required>
        </div>
        <div class="form-group">
          <label > Town</label>
          <input type="text" id="town" name="town" class="form-control" required>
        </div>
        <div class="form-group">
          <label > Description</label>
          <textarea id="description" name="description" class="form-control" required></textarea>
        </div>
        <div class="form-group">
          <label > Dislayable Address</label>
          <input type="text" id="address" name="address" class="form-control" required>
        </div>
        
        <div class="form-group">
            <label>Select Image</label>
            <input type="file" name="image_full" accept="image/*" class="form-control" id="image_full" required>
        </div>

        <!--  -->

        <div class="form-group">
            <select name="num_bedrooms" class="custom-select" required>
                <option selected value=''>Number of Bedrooms</option>
                
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
            </select>
        </div>
        
        <div class="form-group">
            <select name="num_bathrooms" class="custom-select" required>
                <option selected value=''>Number of Bathrooms</option>
                
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
            </select>
        </div>

        <div class="form-group">
          <label >  Price</label>
          <input type="number" id="price" name="price" class="form-control" required>
        </div>

        <div class="form-group">
            <select name="property_type_id" class="custom-select" required>
                <option selected value=''>Property Type</option>
                
                <option value="1">Flat</option>
                <option value="2">Detatched</option>
                <option value="3">Semi-detached</option>
                <option value="4">Terraced</option>
            </select>
        </div>

        <div class="form-group">
        <label>  Type</label>

          <input type="radio"  name="type" value="sale" required >Sale
          <input type="radio"  name="type" value="rent" >Rent
        </div>

        <button type="submit" class="btn btn-primary">Submit</button>
      </form>
    </div>
  </div>
</div>    

@endsection