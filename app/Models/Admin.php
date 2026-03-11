<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;

class Admin extends Authenticatable
{
   /** @use HasFactory<\Database\Factories\UserFactory> */
   use HasFactory, Notifiable;
    Protected $guard = 'admin';
   /**
    * The attributes that are mass assignable.
    *
    * @var array<int, string>
    */
   protected $fillable = [
       'name',
       'email',
       'password',
       'is_super_admin',
       'permissions',
       'is_active',
   ];

   /**
    * The attributes that should be hidden for serialization.
    *
    * @var array<int, string>
    */
   protected $hidden = [
       'password',
       'remember_token',
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
           'is_super_admin' => 'boolean',
           'permissions' => 'array',
           'is_active' => 'boolean',
       ];
   }

   public function canAccess(string $permission): bool
   {
       if ($this->is_super_admin || is_protected_admin_email($this->email)) {
           return true;
       }
       $permissions = $this->permissions ?? [];
       return is_array($permissions) && in_array($permission, $permissions, true);
   }
}
