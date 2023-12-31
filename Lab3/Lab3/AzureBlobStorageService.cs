﻿using Azure.Storage.Blobs;
using System;
using System.IO;

public class AzureBlobStorageService
{
    private readonly BlobContainerClient _blobContainerClient;

    public AzureBlobStorageService(BlobContainerClient blobContainerClient)
    {
        _blobContainerClient = blobContainerClient ?? throw new ArgumentNullException(nameof(blobContainerClient));
    }

    public string UploadPhoto(string photoFilePath, string contactRowKey)
    {
        if (string.IsNullOrEmpty(photoFilePath) || !File.Exists(photoFilePath))
        {
            return null;
        }

        var blobClient = _blobContainerClient.GetBlobClient($"{contactRowKey}_photo.jpg");

        using (var fileStream = File.OpenRead(photoFilePath))
        {
            blobClient.Upload(fileStream);
        }

        var photoUrl = blobClient.Uri.ToString();
        return photoUrl;
    }


    public void DeletePhoto(string contactRowKey)
    {
        var blobClient = _blobContainerClient.GetBlobClient($"{contactRowKey}_photo.jpg");

        blobClient.DeleteIfExists();
    }

    public byte[] DownloadPhoto(string contactRowKey)
    {
        var blobClient = _blobContainerClient.GetBlobClient($"{contactRowKey}_photo.jpg");

        // Check if the blob exists before attempting to download
        if (!blobClient.Exists())
        {
            // Handle the case where the blob does not exist
            // You may choose to return a default photo or null, or log a message
            return null;
        }

        using (var memoryStream = new MemoryStream())
        {
            blobClient.DownloadTo(memoryStream);
            return memoryStream.ToArray();
        }
    }

}
