<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">

<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8">

    {$JAVASCRIPT}
    {$TABLEGRIDJS}
    {$CSSSYSTEM}
    {$TABLEGRIDCSS}
    {$TITLETAB}
</head>

<body>
    
    <legend>{$TITLEFORM}</legend>

    {$FORM1}
    <div class="row">
        <div class="block">
            {foreach from=$modulos item=m name=modulos}
            <table>
                <tbody>
                    <tr>
                        <button type="button" class="collapsible">
                            <label><img src="{$m.path_imagen}" width="25" height="25" >&nbsp;&nbsp;{$m.descripcion}</label>
                            <label class="switch">
                                <input type="checkbox" id="c_modulo" name="c_modulo" onclick="" value="{$m.consecutivo}"><span class="slider round"></span>
                            </label>
                        </button>
                        <div class="content">
                            {foreach from=$children item=c name=children}
                                {if $c.nivel_superior eq $m.consecutivo}
                                    <p><img src="{$c.path_imagen}" width="25" height="25" >&nbsp;&nbsp;{$c.descripcion}
                                    <label class="switch">
                                        <input type="checkbox" id="c_children" name="c_children" onclick="" value="{$c.consecutivo}"><span class="slider round"></span>
                                    </label></p>
                                {/if}
                            {/foreach}
                        </div>
                    </tr>
                </tbody>
            </table>
            {/foreach}
        </div>
    </div>
    {$FORM1END}
</body>

</html>