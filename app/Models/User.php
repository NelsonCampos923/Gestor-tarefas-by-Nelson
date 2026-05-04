use Illuminate\Database\Eloquent\Relations\HasMany;

// Um utilizador tem muitas tarefas
public function tarefas(): HasMany
{
    return $this->hasMany(Tarefa::class);
}