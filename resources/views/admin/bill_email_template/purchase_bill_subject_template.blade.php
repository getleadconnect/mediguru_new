<div width="100%">
<table style="width:100%;" border=0>
<tr>
<td style="width:60%" valign="top"><span style="font-size:34px;font-weight:600;padding-left:50px;">INVOICE</span></td>
<td>
<img src="{{ public_path('media/logos/logo1.png') }}" style="width:150px;"><br>
<label style="font-size:16px;line-height:25px;font-weight:600;">MEDI-FUTURA PRIVATE LIMITED</label><br>
<label style="font-size:14px;line-height:25px;">18/509, HAROON MANZIL, PAYYANAD</label><br>
<label style="font-size:14px;line-height:25px;">MANJERI , MALAPPURAM -676122</label><br>
<label style="font-size:14px;line-height:25px;">GSTIN: <span style="font-weight:600;">32AAMCM8833C1ZI</span></label><br>
</td>

</tr>
<tr><td colspan=2><hr></td></tr>
</table>
<table style="width:100%;" border=0>
<tr>
<td style="width:70%" valign="top">
<label style="font-size:14px;line-height:35px;font-weight:600;">Billed To:</label><br>
<label style="font-size:16px;line-height:25px;font-weight:600;">{{$stdata['student_name']}} </label><br>
<label style="font-size:14px;line-height:25px;">Mob:&nbsp;{{$stdata['student_mobile']}}</label><br>
<label style="font-size:14px;line-height:25px;">Email:&nbsp;{{$stdata['student_email']}}</label><br>
</td>

<td style="width:30%" valign="top">
<label style="font-size:14px;line-height:35px;font-weight:600;">Invoice Details:</label>
<p style="font-size:14px;width:100%;"><span style="font-weight:600;">Invoice No:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>{{$stdata['invoice_no']}}</p>
<p style="font-size:14px;"><span style="font-weight:600;">Invoice Date:</span>&nbsp;&nbsp;&nbsp;&nbsp;{{date('d-m-Y')}}</p>
</td>
</tr>
<tr> <td colspan="2" style="height:50px;">&nbsp;</td></tr>
</table>

<table style="width:100%;" border=0>
<tr style="font-size:12px;">
<th align="left">PARTICULARS</th>
<th align="right">HSN.NO</th>
<th align="right">QTY</th>
<th align="right">RATE</th>
<th align="right">TAX AMT.</th>
<th align="right">GST</th>
<th align="right">CGST</th>
<th align="right">SGST</th>
<th align="right">AMOUNT</th>
</tr>
<tr><td colspan=9><hr style="margin:0px;padding:0px;"></td></tr>

@foreach($data as $r)
<tr style="line-height:25px;font-size:14px;" ><td align="left">{{$r['course_name']}}</td>
<td align="right">999294</td>
<td align="right">1</td>
<td align="right">{{number_format($r['rate'],2,'.','')}}</td>
<td align="right">{{number_format($r['tax_amt'],2,'.','')}}</td>
<td align="right">{{$r['gst_percentage']."%"}}</td>
<td align="right">{{number_format($r['gst_val'],2,'.','')}}</td>
<td align="right">{{number_format($r['gst_val'],2,'.','')}}</td>
<td align="right">{{number_format($r['tax_amt'],2,'.','')}}</td>
</tr>
@endforeach

<tr><td colspan=9>&nbsp;</td></tr>
<tr><td colspan=9>&nbsp;</td></tr>
<tr><td colspan=9>&nbsp;</td></tr>
<tr><td colspan=9>&nbsp;</td></tr>

<tr><td colspan=9><hr style="margin:0px;padding:0px;"></td></tr>
<tr style="height:25px;font-size:18px;"><td colspan="8" align="right">Sub Total</td><td style="font-weight:600;" align="right">{{number_format($data[0]['total_amount'],2,'.','')}}</td></tr>
<tr style="height:25px;font-size:18px;"><td colspan="8" align="right">Taxable Amount</td><td style="font-weight:600;" align="right">{{number_format($data[0]['total_amount'],2,'.','')}}</td></tr>
<tr style="height:25px;font-size:18px;"><td colspan="8" align="right">CGST</td><td style="font-weight:600;" align="right">{{number_format($data[0]['total_gst'],2,'.','')}}</td></tr>
<tr style="height:25px;font-size:18px;"><td colspan="8" align="right">SGST</td><td style="font-weight:600;" align="right">{{number_format($data[0]['total_gst'],2,'.','')}}</td></tr>
<tr style="height:25px;font-size:18px;"><td colspan="6" align="right">&nbsp;</td><td colspan=3><hr> </td></tr>
<tr style="height:25px;font-size:18px;"><td colspan="8" align="right">Amount Payable</td><td style="font-size:24px;font-weight:600;" align="right">{{number_format($data[0]['total_amount'],2,'.','')}}</td></tr>
<tr><td colspan=6>&nbsp;</td><td colspan=3><hr style="margin:0px;"></td></tr>
<tr><td colspan=9>&nbsp;</td></tr>
</table>
<table width="100%">
<tr>
<td style="height:100px;width:40%;font-weight:600;" align="left">
&nbsp;
</td>
<td style="width:25%;font-weight:600;" align="center" valign="bottom">Common Seal</td>
<td style="width:35%;font-weight:600;" align="right" valign="bottom">Authorized Signatory</td>
<tr><td colspan=4><hr style="margin:0px;"></td></tr>
<tr><td colspan=4><span style="font-size:9px;">(This is a computer generated invoice and there is no need for physical signatures and seals )</span></td></tr>

<tr><td colspan=4>&nbsp;</td></tr>
<tr><td colspan=4>&nbsp;</td></tr>

</table>

