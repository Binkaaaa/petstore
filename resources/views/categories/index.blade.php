<ul>
  @foreach($categories as $category)
    <li>
      <a href="{{ route('products.byCategory', $category->name) }}">
        {{ ucfirst($category->name) }}
      </a>
    </li>
  @endforeach
</ul>
