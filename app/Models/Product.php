// ...existing code...
protected $fillable = [
    'name', 'description', 'price', 'image',
    'nome', 'descricao', 'preco', 'imagem'
];
// ...existing code...
public function getImageUrl()
{
    // Verifica ambos os campos (inglês e português)
    $img = $this->image ?? $this->imagem;
    return $img ? asset($img) : asset('images/default-product.png');
}
// ...existing code...
