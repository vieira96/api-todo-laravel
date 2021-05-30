<p>Olá {{ $user->first_name }}.</p>
<p>Você solicitou alteração da senha da sua conta {{ config('app.name') }}. Por favor, clique no link abaixo</p>

<table role="presentation" border="0" cellpadding="0" cellspacing="0" class="btn btn-primary">
    <tbody>
        <tr>
            <td align="center">
                <table role="presentation" border="0" cellpadding="0" cellspacing="0">
                    <tbody>
                        <tr>
                            <td> <a href="{{ $resetPasswordLink }}" target="_blank">REDEFINIR SENHA</a></td>
                        </tr>
                    </tbody>
                </table>
            </td>
        </tr>
    </tbody>
</table>

<p>Ou simplesmente copie e cole o link abaixo em seu navegador.</p>
<p> {{ $resetPasswordLink }}</p>

<p>Por favor, ignore esse e-mail se você não solicitou a altração de senha.</p>
