<?php 
namespace App\Livewire;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use Livewire\Attributes\Title;
use Jantinnerezo\LivewireAlert\LivewireAlert;

#[Title('My Account | Spartan Commerce')]
class MyAccount extends Component
{
    use LivewireAlert;

    public $user;
    public $newPassword;
    public $newPasswordConfirmation;
    public $newUserName;
    public $disableButton = false;

    public function mount()
    {
        $this->user = Auth::user();
        $this->newUserName = $this->user->name;
    }

    public function updateAccount()
    {
        // Validate username
        $this->validate([
            'newUserName' => 'required|string|max:255',
        ]);

        if ($this->newUserName !== $this->user->name) {
            $this->user->name = $this->newUserName;
            $this->user->save();

            // Show success alert
            $this->alert('success', 'Your Account Name has been updated successfully!', [
                'position' => 'bottom-end',
                'timer' => 3000,
                'toast' => true,
            ]);
        }

        // Only validate and update the password if new password fields are provided
        if ($this->newPassword && $this->newPasswordConfirmation) {
            $this->validate([
                'newPassword' => 'required|min:6',  // Ensure confirmation field is validated
            ]);

            // Update password
            $this->user->password = Hash::make($this->newPassword);
            $this->user->save();

            // Show success alert
            $this->alert('success', 'Your Password has been updated successfully!', [
                'position' => 'bottom-end',
                'timer' => 3000,
                'toast' => true,
            ]);
        }
    }

    // Reactively check if the username and password are the same as current values
    public function checkButtonStatus()
    {
        if ($this->newUserName === $this->user->name && (!$this->newPassword || $this->newPassword === $this->user->password)) {
            $this->disableButton = true;
        } else {
            $this->disableButton = false;
        }
    }

    public function render()
    {
        // Check button status when rendering the page or after any property is updated
        $this->checkButtonStatus();

        return view('livewire.my-account');
    }
}
