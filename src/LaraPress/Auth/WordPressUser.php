<?php namespace LaraPress\Auth;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class WordPressUser extends Model implements AuthenticatableContract, CanResetPasswordContract {

    use Authenticatable;

    public $timestamps = false;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'wp_users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['user_login', 'user_nicename', 'user_email', 'display_name', 'user_pass'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['user_pass', 'remember_token'];

    /**
     * @param $capability
     *
     * @return bool
     */
    public function can($capability)
    {
        return user_can($this->ID, $capability);
    }

    /**
     * Get the password for the user.
     *
     * @return string
     */
    public function getAuthPassword()
    {
        return $this->user_pass;
    }

    /**
     * Get the e-mail address where password reset links are sent.
     *
     * @return string
     */
    public function getEmailForPasswordReset()
    {
        return $this->user_email;
    }

    /**
     * Update the user properties.
     *
     * @param array $attributes
     *
     * @return \LaraPress\User\User|\WP_Error
     */
    public function update(array $attributes = [])
    {
        $attributes = array_merge($attributes, ['ID' => $this->ID]);

        if (is_wp_error(wp_update_user($attributes)))
        {
            return false;
        }

        $this->setRawAttributes($attributes, true);

        return true;
    }
}
