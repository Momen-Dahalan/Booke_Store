<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;
use Laravel\Cashier\Billable;


class User extends Authenticatable
{
    use HasApiTokens;

    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;
    use Billable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array<int, string>
     */
    protected $appends = [
        'profile_photo_url',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }


    public function books(){
        return $this->belongsToMany(Book::class , 'book_user');
    }


    public function isAdmin()
{
    return $this->adminstration_level > 0; // يجب أن تعود true إذا كان المستخدم Admin
}

public function isSuperAdmin()
{
    return $this->adminstration_level > 1; // يجب أن تعود true إذا كان المستخدم SuperAdmin
}


public function ratings(){
    return $this->hasMany(Rating::class);
}

public function rated(Book $book){
    return $this->ratings->where('book_id' , $book->id)->isNotEmpty();
}

public function bookRating(Book $book){
    return $this->rated($book) ? $this->ratings->where('book_id' , $book->id)->first() : Null ;
}

public function booksInCart(){
    return $this->belongsToMany(Book::class)->withPivot(['number_of_copies' , 'bought' , 'price'])->wherePivot('bought' , false);
}


public function ratedPurches(){
    return $this->belongsToMany(Book::class)->withPivot([ 'bought'])->wherePivot('bought' , true);
}

public function purchedProduct()
{
    return $this->belongsToMany(Book::class)
                ->withPivot(['bought', 'number_of_copies', 'price', 'created_at'])
                ->orderBy('pivot_created_at', 'desc')
                ->wherePivot('bought', true);
}






}
