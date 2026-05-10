<?php
// dd($user);
?>
<div class="form-group my-2">
    <label>Имя</label>
    <input type="text" name="name" placeholder="Имя"
           class="form-control"
           value="{{ old('name', $user->name ?? '') }}">
    @error('name')
    <div class="error">{{ $message }}</div>
    @enderror
</div>

<div class="form-group my-2">
    <label>E-mail</label>
    <input type="email" name="email"
           class="form-control" placeholder="E-mail"
           value="{{ old('email', $user->email ?? '') }}">
    @error('email')
    <div class="error">{{ $message }}</div>
    @enderror
</div>

<div class="form-group my-2">
    <label>Пароль</label>
    <input type="password" name="password" class="form-control" placeholder="Пароль">
    @error('password')
    <div class="error">{{ $message }}</div>
    @enderror
</div>
