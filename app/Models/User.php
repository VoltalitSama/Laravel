<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Enums\Roles;
use App\Providers\RouteServiceProvider;
use App\Services\AuthenticationService;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Mail;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Mail\Message;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'authentication_token',
        'authentication_token_generated_at',
        'role'
        ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'authentication_token',
        'authentication_token_generated_at',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'authentication_token_generated_at' => 'datetime',
        'role' => Roles::class,
    ];

    public function sendAuthenticationMail(?string $redirect_to = null): void
    {
        $authenticationSerive = new AuthenticationService($this);

        $url = route('auth.authentication.callback', [
            'token' => $authenticationSerive->createToken(),
            'email' => $this->email,
            'redirect_to' => $redirect_to ?? url(RouteServiceProvider::HOME),
        ]);

        Mail::raw("Pour vous identifier au site, veuillez cliquer <a href='$url'>ici</a>", function (Message $mail) {
            $mail->to($this->email)
                ->from('no-reply@u-picardie.fr')
                ->subject('Connectez-vous à votre site préféré');
        });
    }
}
