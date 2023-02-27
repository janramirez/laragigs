<h1>{{$heading}}</h1>

@unless (count($listings) == 0)
@foreach ($listings as $listing)
<h3>
    <a href="/listings/{{$listing['id']}}">{{$listing['title']}}</a>
</h3>
<p>{{$listing['description']}}</p>
@endforeach

@else
<p>No listings available</p>
@endunless